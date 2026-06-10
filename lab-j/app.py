import sqlite3

from flask import Flask, render_template, request, redirect, url_for, abort, g



app = Flask(__name__)
DATABASE = 'data.db'


def get_db():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = sqlite3.connect(DATABASE)
        db.row_factory = sqlite3.Row  # Pozwala odwoływać się do kolumn po nazwach (jak słownik)
    return db



@app.teardown_appcontext
def close_connection(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()


def init_db():
    with app.app_context():
        db = get_db()
        # Prosta migracja
        db.execute('''
            CREATE TABLE IF NOT EXISTS game (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                description TEXT NOT NULL
            )
        ''')
        db.commit()


init_db()



@app.route('/')
def home():
    return redirect(url_for('index'))

@app.route('/games')
def index():
    cur = get_db().execute('SELECT * FROM game')
    games = cur.fetchall()
    return render_template('game/index.html', title='Games List', games=games)

@app.route('/games/create', methods=('GET', 'POST'))
def create():
    if request.method == 'POST':
        title = request.form['title']
        description = request.form['description']
        db = get_db()
        db.execute('INSERT INTO game (title, description) VALUES (?, ?)', (title, description))
        db.commit()
        return redirect(url_for('index'))

    return render_template('game/create.html', title='Create Game', game={})


@app.route('/games/<int:id>')
def show(id):
    game = get_db().execute('SELECT * FROM game WHERE id = ?', (id,)).fetchone()
    if game is None:
        abort(404, description=f"Missing game with id {id}")
    return render_template('game/show.html', title='Game Details', game=game)


@app.route('/games/<int:id>/edit', methods=('GET', 'POST'))
def edit(id):
    db = get_db()
    game = db.execute('SELECT * FROM game WHERE id = ?', (id,)).fetchone()
    if game is None:
        abort(404, description=f"Missing game with id {id}")

    if request.method == 'POST':
        title = request.form['title']
        description = request.form['description']
        db.execute('UPDATE game SET title = ?, description = ? WHERE id = ?', (title, description, id))
        db.commit()
        return redirect(url_for('index'))

    return render_template('game/edit.html', title=f"Edit Game {game['title']} ({game['id']})", game=game)



@app.route('/games/<int:id>/delete', methods=('POST',))
def delete(id):
    db = get_db()
    db.execute('DELETE FROM game WHERE id = ?', (id,))
    db.commit()
    return redirect(url_for('index'))


if __name__ == '__main__':
    app.run(port=57878, debug=True)