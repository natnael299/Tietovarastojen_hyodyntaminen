from conn import *
from tabulate import tabulate

#get functionalities
def showNaytellija():
 res = cur.execute(""" SELECT nimi, syntymavuosi, hotness FROM nayttelijat""")
 data = res.fetchall()
 table = tabulate(data)
 print(table)

def showOhjaaja():
 res = cur.execute(""" SELECT nimi, syntymavuosi FROM ohjaajat""")
 data = res.fetchall()
 table = tabulate(data)
 print(table)

def showLeffa():
 res = cur.execute(""" SELECT leffat.nimi, valmistumisvuosi, nayttelijat.nimi, ohjaajat.nimi FROM leffat JOIN nayttelijat JOIN ohjaajat WHERE ohjaajat.id=ohjaaja_id AND nayttelijat.id=nayttelija_id  """)
 data = res.fetchall()
 table = tabulate(data)
 print(table)
 
 
#
def getInfo():
    getNum = int(input("Mistä taulukkosta haluat hakea tietoja...?"))
    print("1. nayttelijan taulukosta.....")
    print("2. ohjaajan taulukosta.....")
    print("3. leffan taulukosta.....")
    
    #handle out of range inserts
    if getNum not in range(1, 4):
      print("Pitää valita 1-3")
      
    match getNum:
      case 1:
        showNaytellija()
      case 2:
        showOhjaaja()
      case 3:
        showLeffa()