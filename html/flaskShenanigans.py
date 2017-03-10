# unfinished but working on implementing the sql database using python and the flask framework!
# Sasha B.

from flask import Flask, render_template, json, request
from flask.ext.mysql import MySQL
from werkzeug import generate_password_hash, check_password_hash
import os

from app import create_app, db
from app.models import User, Follow, Role, Permission, Post, Comment
from flask_script import Manager, Shell
from flask_migrate import Migrate, MigrateCommand

mysql = MySQL()
app = create_app(os.getenv('FLASK_CONFIG') or 'default')
manager = Manager(app)
migrate = Migrate(app, db)

# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = 'jay'
app.config['MYSQL_DATABASE_PASSWORD'] = 'jay'
app.config['MYSQL_DATABASE_DB'] = 'BucketList'
app.config['MYSQL_DATABASE_HOST'] = 'localhost'
mysql.init_app(app)

COV = None
if os.environ.get('FLASK_COVERAGE'):
    import coverage
    COV = coverage.coverage(branch=True, include='app/*')
    COV.start()

if os.path.exists('.env'): # imports environment from .env
    for line in open('.env'):
        var = line.strip().split('=')
        if len(var) == 2:
            os.environ[var[0]] = var[1]

def make_shell_context():
    return dict(app=app, db=db, User=User, Follow=Follow, Role=Role,
                Permission=Permission, Post=Post, Comment=Comment)
manager.add_command("shell", Shell(make_context=make_shell_context))
manager.add_command('db', MigrateCommand)


@app.route('/')
def main():
    return render_template('index.html')

@app.route('/showSignIn')
def showSignUp():
    return render_template('signin.html')


@app.route('/signIn',methods=['POST','GET'])
def signUp():
    try:
        # _name = request.form['inputName']
        # _email = request.form['inputEmail']
        # _password = request.form['inputPassword']

        # validate the received values
        if _name and _email and _password:
            
            # All Good, so call MySQL
            
            conn = mysql.connect()
            cursor = conn.cursor()
            # _hashed_password = generate_password_hash(_password)
            # cursor.callproc('sp_createUser',(_name,_email,_hashed_password))
            data = cursor.fetchall()

            if len(data) is 0:
                conn.commit()
                return json.dumps({'message':'User created successfully !'})
            else:
                return json.dumps({'error':str(data[0])})
        else:
            return json.dumps({'html':'<span>Enter the required fields</span>'})

    except Exception as e:
        return json.dumps({'error':str(e)})
    finally:
        cursor.close() 
        conn.close()

if __name__ == "__main__":
    app.run(port=5002)

@manager.command
def profile(length=25, profile_dir=None):
    """Start the application under the code profiler."""
    from werkzeug.contrib.profiler import ProfilerMiddleware
    app.wsgi_app = ProfilerMiddleware(app.wsgi_app, restrictions=[length],
                                      profile_dir=profile_dir)
    app.run()

@manager.command
def deploy():
    # deploy shit
    from flask_migrate import upgrade
    from app.models import Role, User

    # migrate database to latest revision
    upgrade()
    # create user roles
    Role.insert_roles()
    # create self-follows for all users
    User.add_self_follows()


if __name__ == '__main__':
    manager.run()