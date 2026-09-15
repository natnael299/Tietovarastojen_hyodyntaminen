from leffat_funs.conn import *
from leffat_funs.get import *
from leffat_funs.put import *

print("--- Welcome!! ---")
print("mikä haluat tehdää.....?")
print("1. Syöttää tieto")
print("2. hakea tieto")

num = int(input("valitse tauluko syötämällä nuemro 1-2: "))

#handle out of range inserts
if num not in range(1, 3):
  print("Pitää valita 1-2")
else:
#call functions based on inserted number
  match num:
    case 1:
      putInfo()
    case 2:
      getInfo()   