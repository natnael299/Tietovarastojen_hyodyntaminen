from conn import *
from tabulate import tabulate

def  display_paginated(query, params=()):
    page = 0
    while True:
        offset = page * 6
        sql = f"{query} LIMIT %s OFFSET %s"

        cur.execute(sql, (*params, 6, offset))
        data = cur.fetchall()
        print(tabulate(data))

        choice = input("n=next, p=previous, q=quit: ").lower()

        if choice == "n":
            page += 1
        elif choice == "p" and page > 0:
            page -= 1
        elif choice == "q":
            break
        else:
            print("Invalid choice")
            
#1
def getProducts():
  query = "SELECT * FROM products"
  display_paginated(query, params=())
 
 #2
def getCustomers():
  query = "SELECT * FROM customers"
  display_paginated(query, params=())
 
#3
def getOrders():
  query = "SELECT * FROM orders"
  display_paginated(query, params=())
   
#4
def getUserProducts():
 print("--- valitse asiakkas id nähdäsi tilatut tuotet ---")
 print("--- Kun olet valinnut id:n muista paina 'q' ja syöttä se id ---")
 getCustomers() #tulosta kaikki asiakkaita
 id = int(input("Valitse asikkaas id: "))
 query = "SELECT * FROM orders WHERE customer_id=%s"
 display_paginated(query, params=(id))

#5
def getProductOrders():
 print("--- valitse tuote id nähdäsi tilatut tuotet ---")
 print("--- Kun olet valinnut id:n muista paina 'q' ja syöttä se id ---")
 getProducts() #tulosta kaikki tuoteita
 id = int(input("Valitse tuote id: "))
 query = "SELECT * FROM orders WHERE product_id=%s"
 display_paginated(query, params=(id))
 
def checkInfo():
  print("---- mistä haluat hakea tuoteita ----")
  print("1. Tuotteiden taulukosta")
  print("2. asiakkaaiden taulukosta")
  print("3. tilauksen taulukosta")
  print("4. tietty asiakkaan kaikki tuotet")
  print("5. tietty tuoten kaikki tilaukset")
 
 # track the table to be edited
  num = int(input("valitse ooperatioo..."))
    
  if num not in range (1, 6):
    print("Pitää valita 1-5")
    return
    
  match num:
    case 1:
      getProducts()
    case 2:
      getCustomers()
    case 3:
      getOrders()
    case 4:
      getUserProducts()
    case 5:
      getProductOrders()