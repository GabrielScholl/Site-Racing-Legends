# coding=Windows_1252
# ^^^^^^^^^^^^^^^^^^^^^^^^^ DO NOT DELETE THIS LINE ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

# import sqlite3
# from datetime import date 

# def insert(infoList):
#     # infoList = [make, model, avgStart, avgBuyout, today]
#     make, model = infoList[0], infoList[1]

#     connection = sqlite3.connect("allCarPrices.db")
#     crsr = connection.cursor()

#     # is there such car?
#     sqlCommand = """SELECT ID FROM cars WHERE make = ? AND model = ?"""
#     crsr.execute(sqlCommand, (str(make), str(model)))
#     carID = crsr.fetchall()
#     # print(carID)
#     # Yes -> put price there
#     if carID != []:
#         # print('There is such car')
#         insertPrice(infoList, crsr)
#     # No -> insert new car and then put price there
#     else:
#         # print('NO SUCH CAR')
#         insertNewCar(make, model, crsr)
#         # print('I created an entry for that car')
#         insertPrice(infoList, crsr)

#     connection.commit()
#     connection.close()

# def insertNewCar(make, model, crsr):
#     sqlCommand = """INSERT INTO cars(make, model) VALUES(?,?);"""
#     crsr.execute(sqlCommand, (make, model))
#     # connection.commit()

# def insertPrice(infoList, crsr):
#     make, model, avgStart, avgBuyout, today = infoList[0], infoList[1], infoList[2], infoList[3], infoList[4]
#     sqlCommand = """INSERT INTO prices (date, carID, stPrice, boPrice) VALUES (?, (SELECT ID FROM cars WHERE make = ? AND model = ?), ?, ?);"""
#     crsr.execute(sqlCommand, (str(today), str(make), str(model), str(avgStart), str(avgBuyout))) 
#     # connection.commit()

# ===================================================

import difflib

import mysql.connector
import random as rnd
from datetime import date 

def insert(infoList):
    # infoList = [make, model, avgStart, avgBuyout, today]
    make, model = infoList[0], infoList[1]

    db = mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="allcarprices"
    )

    cur = db.cursor()

    # fuzzy funnels it to the correct car


    # is there such car?
    sqlCommand = """SELECT ID FROM cars WHERE make = %s AND model = %s"""
    cur.execute(sqlCommand, (str(make), str(model)))
    carID = cur.fetchall()
    # print(carID)
    # Yes -> put price there
    if carID != []:
        # print('There is such car')
        insertPrice(infoList, cur)
    # No -> insert new car and then put price there
    else:
        # print('NO SUCH CAR')
        insertNewCar(make, model, cur)
        # print('I created an entry for that car')
        insertPrice(infoList, cur)

    db.commit()
    # print('comitei')
    # db.close()

def insertNewCar(make, model, cur):
    sqlCommand = """INSERT INTO cars(make, model) VALUES(%s,%s);"""
    cur.execute(sqlCommand, (str(make), str(model)))

def insertPrice(infoList, cur):
    make, model, avgStart, avgBuyout, today = infoList[0], infoList[1], infoList[2], infoList[3], infoList[4]
    if avgStart != "No listing found" and avgBuyout != "No listing found": 
        sqlCommand = """INSERT INTO prices (date, carID, stPrice, boPrice) VALUES (%s, (SELECT ID FROM cars WHERE make = %s AND model = %s), %s, %s);"""
        cur.execute(sqlCommand, (str(today), str(make), str(model), str(avgStart), str(avgBuyout))) 
    else:
        sqlCommand = """INSERT INTO prices (date, carID, stPrice, boPrice) VALUES (%s, (SELECT ID FROM cars WHERE make = %s AND model = %s), NULL, NULL);"""
        cur.execute(sqlCommand, (str(today), str(make), str(model)))

# for i in range(10):
#     for d in range(1, 8, 1):
#         st = str(rnd.choice(range(1000, 10000000, 1000)))
#         bo = str(rnd.choice(range(1000, 10000000, 1000)))
#         while bo < st:
#             bo = str(rnd.choice(range(1000, 10000000, 1000)))
#         infoList = ['marca'+str(i), 'modelo', st, bo, '2020-10-'+str(d)]
#         insert(infoList)