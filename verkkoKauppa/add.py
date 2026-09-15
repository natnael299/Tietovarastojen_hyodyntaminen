from conn import *
from get import *

#The functionalities
def addToProducts():
  nimi = input("Tuoten nimi ...: ")
  price = float(input("Tuoten hinta ...: "))
  cur.execute("INSERT INTO products (name, price) VALUES(%s,%s)", (nimi, price))
  print("lisäys onnistui ")
  db.commit()
  

def addToCustomers():
  etuNimi = input("Tuoten nimi ...: ")
  sukuNimi = input("Tuoten nimi ...: ")
  osoitte = input("Tuoten nimi ...: ")
  cur.execute("INSERT INTO customers (first_name, last_name, address) VALUES(%s,%s,%s)", (etuNimi, sukuNimi, osoitte))
  print("lisäys onnistui ")
  db.commit()
  

def addToOrders():
  getProducts()
  product_id = int(input("Valiste tuottein id taulukosta ...: "))
  
  getCustomers()
  customer_id = int(input("Valiste asiakkas id taulukosta ...: ")) 
  cur.execute("INSERT INTO orders (product_id, customer_id) VALUES(%s,%s)", (product_id, customer_id))
  print("lisäys onnistui ")
  db.commit()
  

# the main insert functionality
def addInfo():
  print("***** Mitä haluat lisätä *****")
  print("1. Tuotteita")
  print("2. Asiakkaita")
  print("3. Tilauksia")
  
# track the table to be edited
  num = int(input("valitse taulukko johon haluat lisätä tietoja...: "))
  
  if num not in range (1, 4):
   print("Pitää valita 1-3")
   return
   
  match num:
    case 1:
      addToProducts()
    case 2:
      addToCustomers()
    case 3:
      addToOrders()