from conn import *
from add import  *
from delete import  *
from get import  *

print("***** Tervetulloa verkkokauppammelle *****")

print("---Mitä Haluat Tehdä---")
print("1. Lisätä tietoja")
print("2. Poista tietoja")
print("3. Tarkastella tietoja")

num = int(input("Syötä numero valitsemasi palvelun...: "))

if num not in range (1, 4):
  print("Pitää valita 1-4")
else:
  match num:
    case 1:
      addInfo()
    case 2:
      removeInfo()
    case 3:
      checkInfo()