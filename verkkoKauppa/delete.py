from conn import *
from get import *

def removeFromProducts():
  getProducts() #displays the table
  id = int(input("Valitse sarakkeen id jonka haluat poista: "))
  cur.execute("DELETE FROM products WHERE id=%s", (id,))
  db.commit()
  db.close()
   
def removeFromCustomers():
  getCustomers() #displays the table
  id = int(input("Valitse sarakkeen id jonka haluat poista: "))
  cur.execute("DELETE FROM customers WHERE id=%s", (id,))
  db.commit()
  db.close()

def removeFromOrders():
  getOrders() #display the table
  id = int(input("Valitse sarakkeen id jonka haluat poista: "))
  cur.execute("DELETE FROM orders WHERE id=%s", (id,))
  db.commit()
  db.close()

#the main deletion functionality
def removeInfo():
  print("***** Mistä taulukosat haluat poista tiedon *****")
  print("1. Tuotteiden taulukosta")
  print("2. Asiakkaiden taulukosta")
  print("3. Tilauksien taulukosta")
 
# track the table to be edited
  num = int(input("valitse taulukko johon haluat lisätä tietoja..."))
  
  if num not in range (1, 4):
   print("Pitää valita 1-3")
   return
   
  match num:
    case 1:
      removeFromProducts()
    case 2:
      removeFromCustomers()
    case 3:
      removeFromOrders()