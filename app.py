from flask import Flask, jsonify
import mysql.connector #bizni MySQL server bilan bog'ledi
app = Flask(__name__)
#Har doim boshlanmaslik uchun class yaratib olamiz
class DB: 
    db = mysql.connector.connect(
    host="127.0.0.1", # Mysql serverimiz hostini yozamiz
    user="root", #Mysql serverni logini
    passwd="", #Paroli
    database="school"# va biz yaratgan malumotlar ombori
    )
    cursor = db.cursor(dictionary=True)
   
db = DB() #yaratib olgan classimizdan object yaratamiz
cursor = db.cursor # cursorni ajratib olamiz, so'rov jonatish oson bo'lishi uchun

def isCon(): #bu funksiya MySQL server bilan doimiy aloqani taminlaydi
    global db
    if db.db.is_connected()==False: #Agar uzilish bo'lgan bolsa
        db.db.reconnect()#Boshidan ulanadi
        print("Reconnected")
@app.before_request
def before_request():
    isCon() #Har bir so'rov oldidan MySQL bilan boglanishni tekshirib olamiz

@app.route("/") # http://127.0.0.1:5000 ga o'tkanimizda ishledi
def hello():
    return jsonify({"msg": "Hello World"}) 
 
@app.route("/sinflar") # http://127.0.0.1:5000/sinflar ga o'tkanimizda ishledi
def classes():
    cursor.execute("SELECT * FROM classes") # MySQL so'rovini yuboramiz
    result = cursor.fetchall() #Bizga qaytgan malumotni saqlemiz
    return jsonify(result) # Va JSON tarzda qaytaramiz

if __name__ == "__main__":
    app.run() 
