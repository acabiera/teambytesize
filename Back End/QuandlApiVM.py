import sys
import quandl
import json
import pandas
import pgdb

hostname = 'localhost'
username = 'scservice'
password = 'Uark1234'
database = 'scservice'
conn = pgdb.connect(host=hostname, user=username, password=password, dbname=database)
cur = conn.cursor()

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

def doQuery(conn, cur, query):
    cur.execute(query)
    conn.commit()

def closeConnection(conn, cur):
    cur.close()
    conn.close()

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

def pastPrice(name):
    query = "SELECT price FROM materials WHERE name='" + name + "'"
    result = cur.execute(query)
    conn.commit()
    names = result.fetchall()
    for row in names:
        return row.price

materials = []
with open('materials.txt') as inputfile:
    for line in inputfile:
        string = line.replace('\n', '')
        materials.append(string.split('+'))

for x in range(len(materials)):
    name = materials[x][0]
    productname = materials[x][1]
    code = materials[x][2]
    cents = materials[x][3]
    price = getPrice(code, cents)
    pastprice = pastPrice(productname)
    print "checking " + productname + "\n"
    print "price = " + str(price)
    print "pastprice = " + str(pastprice) + "\n"
    if str(price) != str(pastprice):
        print "!------Updating" + productname + "------!\n"
        query = "UPDATE materials SET price = " + price + " WHERE name = '" + productname + "';"
        doQuery(conn, cur, query)

closeConnection(conn, cur)

#queries
#query = "SELECT EXISTS(SELECT unitweight FROM mlightbulb WHERE name = 'iron wire');"
#INSERT INTO materials VALUES (uuid_generate_v4(), name, price, weight)
