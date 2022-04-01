# # importing the module 
# import sqlite3 

# # connect withe the myTable database 
# connection = sqlite3.connect("allCarPrices.db") 

# # cursor object 
# crsr = connection.cursor() 

# # execute the command to fetch all the data from the table emp 
# crsr.execute("SELECT * FROM cars LIMIT 1000") 

# # store all the fetched data in the ans variable 
# cars = crsr.fetchall() 

# # execute the command to fetch all the data from the table emp 
# crsr.execute("SELECT * FROM prices") 

# # store all the fetched data in the ans variable 
# prices = crsr.fetchall() 

# connection.close() 
# # Since we have already selected all the data entries 
# # using the "SELECT *" SQL command and stored them in 
# # the ans variable, all we need to do now is to print 
# # out the ans variable 

# print("(SELECT * FROM cars) returned the following")
# for car in cars:
#     print(car)
# # print("(SELECT * FROM prices) returned the following")
# # print(prices)

# =======================================================

import mysql.connector

db = mysql.connector.connect(
  host="sql435.main-hosting.eu",
  user="u368804575_poripipperson",
  password="V@ppe*%yar96?oG3",
  database="u368804575_allcarprices"
)

cur = db.cursor()

# make = 'ABARTH'
# model = "ABARTH 124 '17"
# cur.execute("SELECT model FROM cars WHERE ID = (SELECT ID FROM cars WHERE make = 'ABARTH' AND model = 'ABARTH 124 ''17')")
# command = "SELECT * FROM prices WHERE carID = (SELECT ID FROM cars WHERE model = 'ABARTH 124 ''17');"
command = "SELECT * FROM cars;"
cur.execute(command) 

cars = cur.fetchall() 

# cur.execute("SELECT * FROM prices WHERE model = 'ABARTH 124 ''17';") 
# cur.execute("SELECT model FROM cars") 

# prices = cur.fetchall() 

print(command + " returned the following")
for car in cars:
    print(car)
# allMakes = []
# for car in cars:
#   carr = car[0]
#   if carr not in allMakes:
#     allMakes.append(carr)
# print(allMakes)

# file = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\makesNmodels.txt'

# f = open(file, "w")
# for i in allMakes:
#   f.write(i+'\n')
# f.write('\n')

# print("(SELECT * FROM prices) returned the following")
# for val in prices:
#     print(val)

# allModels = []
# print("(SELECT model FROM cars) returned the following")
# for val in prices:
#   vall = val[0]
#   allModels.append(vall)
# print(allModels)

# for i in allModels:
#   f.write(i+'\n')
# f.close()