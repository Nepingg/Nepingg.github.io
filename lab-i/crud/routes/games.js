var express = require('express');
var router = express.Router();
const { DatabaseSync } = require('node:sqlite');
const path = require('node:path');

const dbPath = path.resolve(__dirname, '..', 'data.db');
const db = new DatabaseSync(dbPath);

db.exec(`
  CREATE TABLE IF NOT EXISTS game (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL
  )
`);

router.get('/', (req, res) => {
    const games = db.prepare('SELECT * FROM game').all();
    res.render('games/index', { title: 'Games List', games });
});

router.get('/create', (req, res) => {
    // Przekazujemy pusty obiekt game, by uniknąć błędu w widoku
    res.render('games/create', { title: 'Create Game', game: {} });
});

router.post('/create', (req, res) => {
    const { title, description } = req.body;
    const stmt = db.prepare('INSERT INTO game (title, description) VALUES (?, ?)');
    stmt.run(title, description);
    res.redirect('/games');
});

router.get('/:id', (req, res) => {
    const game = db.prepare('SELECT * FROM game WHERE id = ?').get(req.params.id);
    if (!game) return res.status(404).send('Missing game with id ' + req.params.id);
    res.render('games/show', { title: `Game Details`, game });
});

router.get('/:id/edit', (req, res) => {
    const game = db.prepare('SELECT * FROM game WHERE id = ?').get(req.params.id);
    if (!game) return res.status(404).send('Missing game with id ' + req.params.id);
    res.render('games/edit', { title: `Edit Game ${game.title} (${game.id})`, game });
});

router.post('/:id/edit', (req, res) => {
    const { title, description } = req.body;
    const stmt = db.prepare('UPDATE game SET title = ?, description = ? WHERE id = ?');
    stmt.run(title, description, req.params.id);
    res.redirect('/games');
});

router.post('/:id/delete', (req, res) => {
    db.prepare('DELETE FROM game WHERE id = ?').run(req.params.id);
    res.redirect('/games');
});

module.exports = router;