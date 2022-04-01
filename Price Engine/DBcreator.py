# Python code to demonstrate table creation and 
# insertions with SQL 

# # importing module 
# import sqlite3 

# # connecting to the database 
# connection = sqlite3.connect("allCarPrices.db") 

# # cursor 
# crsr = connection.cursor() 

# # SQL command to create a table in the database 
# sqlCommand = """
# CREATE TABLE cars ( 
#   ID INTEGER PRIMARY KEY AUTOINCREMENT,
#   make VARCHAR(30), 
#   model VARCHAR(30)
# );"""
# # execute the statement 
# crsr.execute(sqlCommand) 

# # SQL command to create a table in the database 
# sqlCommand = """
# CREATE TABLE prices (
#   ID INTEGER PRIMARY KEY AUTOINCREMENT,
#   date VARCHAR(10), 
#   carID INT,
#   stPrice INT(8), 
#   boPrice INT(8)
# );"""


# # execute the statement 
# crsr.execute(sqlCommand) 

# print("DB created successfully!")

# # close the connection 
# connection.close() 

# ===========================================================

import mysql.connector

def dbCreator():
  db = mysql.connector.connect(
  # host="151.106.96.101",
  host="sql435.main-hosting.eu",
  user="u368804575_poripipperson",
  password="V@ppe*%yar96?oG3",
  database="u368804575_allcarprices"
  )

  cur = db.cursor()

  cur.execute("DROP DATABASE allcarprices")
  cur.execute("CREATE DATABASE allcarprices")

def dbDelete():
  db = mysql.connector.connect(
  # host="151.106.96.101",
  host="sql435.main-hosting.eu",
  user="u368804575_poripipperson",
  password="V@ppe*%yar96?oG3",
  database="u368804575_allcarprices"
  )

  cur = db.cursor()

  cur.execute("DROP TABLE cars")
  cur.execute("DROP TABLE prices")

# I don't use dbCreator() anymore as I can delete and create tables
# dbCreator()
dbDelete()

db = mysql.connector.connect(
  # host="151.106.96.101",
  host="sql435.main-hosting.eu",
  user="u368804575_poripipperson",
  password="V@ppe*%yar96?oG3",
  database="u368804575_allcarprices"
)

cur = db.cursor()

cur.execute("""
  CREATE TABLE cars ( 
  ID INT AUTO_INCREMENT PRIMARY KEY,
  make VARCHAR(30), 
  model VARCHAR(30)
);""")

cur.execute("""
  CREATE TABLE prices (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  date VARCHAR(10), 
  carID INT,
  stPrice INT(8), 
  boPrice INT(8)
);""")

# cur.execute("""
#   CREATE USER Poripipperson 
#   IDENTIFIED BY 'V@ppe*%yar96?oG3';
# """)
# cur.execute("""
#   GRANT insert ON allcarprices.cars TO Poripipperson;
# """)

print('done')