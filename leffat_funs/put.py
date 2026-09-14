from leffat_funs.conn import *
from leffat_funs.get import *

def insertTOArtist():
        nimi = input("naytelijan nimi...: ")
        syntymavuosi = int(input("naytelijan ikä...: "))
        hotness = int(input("naytelijan hotness(1-10)...: "))
        cur.execute(""" INSERT INTO nayttelijat (nimi, syntymavuosi, hotness) VALUES(?, ?, ?) """, (nimi, syntymavuosi, hotness))
        conn.commit()
        conn.close()
        print("--- syöttä on onnistunut!! ---")
        
def insertToDirectors():
        nimi = input("ohjaajan nimi...: ")
        syntymavuosi = int(input("ohjaajan ikä...: "))
        cur.execute(""" INSERT INTO ohjaajat (nimi, syntymavuosi) VALUES(?, ?) """, (nimi, syntymavuosi))
        conn.commit()
        conn.close()
        print("--- syöttä on onnistunut!! ---")
        
def insertToMovies():
        nimi = input("leffaan nimi...: ")
        valmistumisvuosi = int(input("leffaan valmistumisvuosi...: "))
        print("---- syöttää ohjaajan id taulukkosta ----")
        showOhjaaja()
        ohjaaja_id = int(input("Ohjaaja id: "))
        showNaytellija()
        nayttelija_id = int(input("Nayttelija id"))
        cur.execute(""" INSERT INTO leffat  (nimi, valmistumisvuosi, ohjaaja_id, nayttelija_id) VALUES(?, ?, ?, ?) """, (nimi, valmistumisvuosi, ohjaaja_id, nayttelija_id))
        conn.commit()
        conn.close()
        
def putInfo():
   insertNum = print("Mihin taulukkoon haluat syöttää....?")
   print("1. nayttelijaan.....")
   print("2. ohjaajaan.....")
   print("3. leffaan.....")
      
   match insertNum:
      case 1:
        insertTOArtist()
      case 2:
        insertToDirectors()
      case 3:
        insertToMovies()