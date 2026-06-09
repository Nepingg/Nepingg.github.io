import sys
import platform
name = "Michał"
user_id = "57878"
python_version = platform.python_version()
python_path = sys.executable
print(f"Hello \033[33m{name}\033[0m (\033[33m{user_id}\033[0m). This environment is using Python version \033[33m{python_version}\033[0m at location \033[33m{python_path}\033[0m.")