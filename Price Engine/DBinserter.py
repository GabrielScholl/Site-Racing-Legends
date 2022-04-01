# coding=Windows_1252
# ^^^^^^^^^^^^^^^^^^^^^^^^^ DO NOT DELETE THIS LINE ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

import difflib

import mysql.connector
import random as rnd
from datetime import date

import wordMatcher

# def insert(infoList):
def insert(allValues):
    # infoList = [make, model, avgStart, avgBuyout, today]
    db = mysql.connector.connect(
        host="sql435.main-hosting.eu",
        user="u368804575_poripipperson",
        password="V@ppe*%yar96?oG3",
        database="u368804575_allcarprices"
    )

    cur = db.cursor()

    for infoList in allValues:
        make, model = infoList[0], infoList[1]
        print("Errado: "+make+" - "+model)
        # fuzzy funnels the above "guess" to the correct car
        make, model = wordMatcher.match(make, model)
        print("Certo: "+make+" - "+model)
        # for SEARCHING in the DB, use makeSQL, for INSERTING, use just make
        # makeSQL deals with apostrophe, adding 2 where there's one and wrapping text in them
        makeSQL = make
        modelSQL = model
        for c in make:
            if c == "'":
                parts = makeSQL.split("'")
                makeSQL = parts[0]+"\'\'"+parts[1]
                break
        for c in model:
            if c == "'":
                parts = modelSQL.split("'")
                modelSQL = parts[0]+"\'\'"+parts[1]
                break

        makeSQL = "'"+makeSQL+"'"
        modelSQL = "'"+modelSQL+"'"

        print("SQL: "+makeSQL+" - "+modelSQL)

        # connect was here x_x

        # is there such car?
        sqlCommand = "SELECT ID FROM cars WHERE make = %s AND model = %s"
        cur.execute(sqlCommand, (str(make), str(model)))
        carID = cur.fetchall()
        print(carID)
        # Yes -> put price there
        if carID != []:
            # print('There is such car')
            insertPrice(infoList, cur, make, model)
        # No -> insert new car and then put price there
        else:
            # print('NO SUCH CAR')
            insertNewCar(make, model, cur)
            # print('I created an entry for that car')
            insertPrice(infoList, cur, make, model)

        db.commit()
    # print('comitei')
    # db.close()

def insertNewCar(make, model, cur):
    sqlCommand = """INSERT INTO cars(make, model) VALUES(%s,%s);"""
    cur.execute(sqlCommand, (str(make), str(model)))

def insertPrice(infoList, cur, make, model):
    avgStart, avgBuyout, today = infoList[2], infoList[3], infoList[4]
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