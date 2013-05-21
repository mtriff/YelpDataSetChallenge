import json

class Business:

	"Object to represent a business"
	def __init__(self, jsonLine):
		decoded=json.loads(jsonLine.strip())
		if decoded["type"]!="business":
			raise Exception("Invalid JSON type")

		self.data={}
		self.data["name"]=decoded["name"]
		self.data["business_id"]=decoded["business_id"]
		self.data["stars"]=decoded["stars"]
		self.data["categories"]=decoded["categories"]
		self.data["location"]={"address":decoded["full_address"],"latitude":decoded["latitude"],"longitude":decoded["longitude"]}
		repeat={"total":0,"users":[]}
		self.data["reviews"]={"total":0,"1star":[],"2star":[],"3star":[],"4star":[],"5star":[], "repeatVisitors":repeat}

	def setVisitTime(self, jsonLine):
		decoded=json.loads(jsonLine.strip())
		if decoded["type"]!="checkin":
			raise Exception("Invalid JSON type, expecting 'checkin'")

		if self.data["business_id"]!=decoded["business_id"]:
			raise Exception("business_id's do not match")

		self.data["visitTime"]=decoded["checkin_info"]

	def addReview(self, jsonLine):
		decoded=json.loads(jsonLine.strip())
		if decoded["type"]!="review":
			raise Exception("Invalid JSON type, expecting 'review'")

		if self.data["business_id"]!=decoded["business_id"]:
			raise Exception("business_id's do not match")		

		if (decoded["user_id"] in self.data["reviews"]["1star"]
				or decoded["user_id"] in self.data["reviews"]["2star"]
				or decoded["user_id"] in self.data["reviews"]["3star"]
				or decoded["user_id"] in self.data["reviews"]["4star"]
				or decoded["user_id"] in self.data["reviews"]["5star"]):
			self.data["reviews"]["repeatVisitors"]["total"]+=1

			if decoded["business_id"] not in self.data["reviews"]["repeatVisitors"]["users"]:
				self.data["reviews"]["repeatVisitors"]["users"].append(decoded["user_id"])

		index="%istar" % decoded["stars"]
		self.data["reviews"][index].append(decoded["user_id"])
		self.data["reviews"]["total"]+=1
