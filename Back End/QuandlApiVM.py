#!/usr/bin/python
#This script is programmed to run everyday at 8:00 A.M. through a chrontab
#It reads the materials.txt which is manuallly written and contains information
#about each product being pulled from the API
import sys
import quandl
import json
import pandas
import pgdb
from datetime import datetime

#connect to the database
hostname = 'localhost'
username = 'scservice'
password = 'Uark1234'
database = 'scservice'
conn = pgdb.connect(host=hostname, user=username, password=password, dbname=database)
cur = conn.cursor()

#inserting a new commodity into materials.txt
if sys.argv.__len__() == 5:
    f = open('QuandlCode.json', 'r')
    j = f.read()
    QuandlJson = json.loads(j)
    f.close()

    name = sys.argv[1]
    unit = sys.argv[2]
    productname = sys.argv[3]
    cents = sys.argv[4]
    code = ''
    for x in range(len(QuandlJson)):
        if QuandlJson[x]['name'] == productname:
            code = QuandlJson[x]['code']
    price = getPrice(code, 'no')
    query = "INSERT INTO materials VALUES (uuid_generate_v4(), '" + name + "', " + price + ", '" + unit + "');"
    doQuery(conn, cur, query)

    string = productname + '+' + name + '+' + code + '+' + cents + '+' + unit + '\n'
    f = open('materials.txt', 'a')
    f.write(string)
    f.close()

#do query funtion will execute query
def doQuery(conn, cur, query):
    cur.execute(query)
    conn.commit()

#close connection to database
def closeConnection(conn, cur):
    cur.close()
    conn.close()

#connect to the quandl api and get the current price of the commodity given
#code = the quandl look up code in materials.txt
#cents = if the price pulled from quandl is in cents
def getPrice(code, cents):
    quandl.ApiConfig.api_key = 'Hj2gbXASP5LCCtZC6UaN'
    request = quandl.get(code, rows='1')
    data = request.values
    data = data[0][0]
    data = float(data)
    if cents == 'yes':
        data = data/100
    data = str(data)
    return data

#get the past price of a given commodity
def pastPrice(name):
    query = "select price from commodities where name = '" + materialname + "';"
    result = cur.execute(query)
    conn.commit()
    price = result.fetchall()
    return price[0].price

materials = []
#open the materials.txt file and read in all the data
with open('/home/jcbronne/materials.txt') as inputfile:
    for line in inputfile:
        string = line.replace('\n', '')
        materials.append(string.split('+'))

#go through every material listed in the materials.txt
#name = material name on quandl
#materialname = material name in the database
#code = quandl code
#cents = if the price is given in cents
for x in range(len(materials)):
    name = materials[x][0]
    materialname = materials[x][1]
    code = materials[x][2]
    cents = materials[x][3]
    print "!------Checking " + materialname + "------!\n"
    price = getPrice(code, cents)
    pastprice = pastPrice(materialname)
    print "price = " + str(price)
    print "pastprice = " + str(pastprice) + "\n"
    if str(price) != str(pastprice):
        print "\tUpdating...\n"
        query = "update commodities set price = " + price + " where name = '" + materialname + "';"
        f = open("commoditylog.txt", "a")
        f.write("(" + materialname + ", past price = " + str(pastprice) + ", new price = " + str(price) + ", " + datetime.now().strftime('%Y-%m-%d %H:%M') + ")\n")
        f.close()
        doQuery(conn, cur, query)

closeConnection(conn, cur)

#queries
#query = "SELECT EXISTS(SELECT unitweight FROM mlightbulb WHERE name = 'iron wire');"
#INSERT INTO materials VALUES (uuid_generate_v4(), name, price, weight)
