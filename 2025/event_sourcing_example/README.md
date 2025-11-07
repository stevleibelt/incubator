# EventSourcing Example

Contains a simplified python application using **Typer**, **SQLAlchemy**, **Dramatiq**, and **Eventsourcing** to fetch data types from an LDAP server for "user" and "contract" aggregates.
This example focuses on structuring the application with the necessary components.

### Directory Structure

```
app/
│
├── main.py
├── models.py
├── services.py
├── task.py
├── events.py
└── requirements.txt
```

### `models.py`

This file contains the SQLAlchemy models representing the `User` and `Contract` aggregates.

```python
from sqlalchemy import create_engine, Column, Integer, String
from sqlalchemy.orm import declarative_base, sessionmaker

Base = declarative_base()

class User(Base):
    __tablename__ = 'users'

    id = Column(Integer, primary_key=True)
    username = Column(String)
    email = Column(String)

class Contract(Base):
    __tablename__ = 'contracts'

    id = Column(Integer, primary_key=True)
    contract_number = Column(String)
    user_id = Column(Integer)

# Database setup
DATABASE_URL = "sqlite:///example.db"  # Change to your database URL
engine = create_engine(DATABASE_URL)
Session = sessionmaker(bind=engine)

Base.metadata.create_all(engine)
```

### `services.py`

This file contains the business logic for fetching data from the LDAP store.

```python
from ldap3 import Server, Connection, ALL
from models import Session, User, Contract

LDAP_SERVER = "ldap://localhost"  # Replace with your LDAP server

def fetch_user_data(username: str):
    server = Server(LDAP_SERVER, get_info=ALL)
    conn = Connection(server, auto_bind=True)
    
    conn.search(f'(&(objectClass=user)(sAMAccountName={username}))', attributes=['cn', 'mail'])
    return conn.entries[0] if conn.entries else None

def fetch_contract_data(user_id: int):
    session = Session()
    return session.query(Contract).filter_by(user_id=user_id).all()
```

### `events.py`

This file outlines the event definitions that can be appended to an event store.

```python
from eventsourcing.domain import Aggregate, AggregateEvent, EventStore

class UserCreated(AggregateEvent):
    pass

class ContractCreated(AggregateEvent):
    pass

class User(Aggregate):
    pass

class Contract(Aggregate):
    pass
```

### `task.py`

This file handles tasks using Dramatiq for parallel processing.

```python
import dramatiq
from services import fetch_user_data, fetch_contract_data

@dramatiq.actor
def process_user(username: str):
    user_data = fetch_user_data(username)
    if user_data:
        # Log or handle user_data
        print(f"Fetched user data: {user_data}")

@dramatiq.actor
def process_contract(user_id: int):
    contracts = fetch_contract_data(user_id)
    if contracts:
        # Log or handle contract data
        print(f"Fetched contracts: {contracts}")
```

### `main.py`

This is the entry point for the application using Typer as a command-line interface.

```python
import typer
from dramatiq import set_broker
from dramatiq.brokers.rabbit import RabbitBroker
from task import process_user, process_contract

app = typer.Typer()

# Setup RabbitMQ as the broker for Dramatiq
rabbit_broker = RabbitBroker(url='amqp://guest:guest@localhost:5672//')  # Update with your connection
set_broker(rabbit_broker)

@app.command()
def get_user(username: str):
    process_user.send(username)

@app.command()
def get_contract(user_id: int):
    process_contract.send(user_id)

if __name__ == "__main__":
    app()
```

### Getting Started

1. **Install Requirements**: 
   Run `pip install -r requirements.txt`.

2. **Start RabbitMQ**: 
   Make sure RabbitMQ is running on your machine.

3. **Initialize the Database**: 
   A SQLite database called `example.db` will be created automatically.

4. **Run the Application**:
   Use the following command to get user data:
   ```bash
   python main.py get-user <username>
   ```
   Or fetch contract data:
   ```bash
   python main.py get-contract <user_id>
   ```

### Overview

- **Typer** handles the command-line interface.
- **SQLAlchemy** manages the database interactions.
- **Dramatiq** processes tasks asynchronously, allowing the fetching of user and contract data in parallel.
- **Eventsourcing** can be expanded to manage state changes and persistence to an event store.

### Links

* [Aufbau hoch skalbierbarer Geschäftssysteme mit CQRS in Python: leapcell.io](https://de.leapcell.io/blog/aufbau-hoch-skalierbarer-geschaeftssysteme-mit-cqrs-in-python) - 20251107
* [Python package `eventsourcing_sqlalchemy`: github.com](https://github.com/pyeventsourcing/eventsourcing-sqlalchemy) - 20251107
* [Implementing CQRS in Python: dev.to](https://dev.to/akhundmurad/implementing-cqrs-in-python-41aj) - 20251107
