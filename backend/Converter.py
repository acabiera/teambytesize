import json

def checkMoneyType(name, price):
    jsonString = [{"name": "Chicken","cents": "yes"},{"name": "Copper","cents": "no"}]
    item = json.load(jsonString)

    #print 'Do you need to convert currency?'
    for x in range(len(item)):
        if item[x]['name'] == name:
            decision = [x]['cents']

    #Price Conversion
    if decision == 'yes':
        #cents = float(input('Enter cents you are converting to dollars: '))
        dollars1 = cents/100;
        #print 'Converted to', dollars1, 'dollars'

        #units = int(input('How many units do you need? (1 or more): '))
        #print 'Total is', dollars1 * units, 'dollars for', units, 'units'

	return dollars1

    elif decision == 'no':
        #dollars2 = float(input('Enter dollars: '))

        units = int(input('How many units do you need? (1 or more)'))

        #Hardcode the string 'units' to whatever name is in the api
        print 'Total is', dollars2 * units, 'dollars for', units, 'units'


    else:
        print 'Invalid argument'
