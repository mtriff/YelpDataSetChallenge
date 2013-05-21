import json

class User:

	"Object to represent a user object"
	def __init__(self, jsonLine):
		decoded=json.loads(jsonLine.strip())
		if decoded["type"]!="user":
			raise Exception("Invalid JSON type")
		
		self.data={}
		self.data["name"]=decoded["name"]
		self.data["user_id"]=decoded["user_id"]
		repeat={"total":0,"businesses":[]}
		self.data["reviews"]={"total":0,"usefulVotes":0,"funnyVotes":0,"coolVotes":0,"repeatReviews":repeat,
								"1star":[],"2star":[],"3star":[],"4star":[],"5star":[]}

	def addReview(self, jsonLine):
		decoded=json.loads(jsonLine.strip())
		if decoded["type"]!="review":
			raise Exception("Invalid JSON type, expecting 'review'")

		if self.data["user_id"]!=decoded["user_id"]:
			raise Exception("user_id's do not match")

		if (decoded["business_id"] in self.data["reviews"]["1star"]
				or decoded["business_id"] in self.data["reviews"]["2star"]
				or decoded["business_id"] in self.data["reviews"]["3star"]
				or decoded["business_id"] in self.data["reviews"]["4star"]
				or decoded["business_id"] in self.data["reviews"]["5star"]):
			self.data["reviews"]["repeatReviews"]["total"]+=1

			if decoded["business_id"] not in self.data["reviews"]["repeatReviews"]["businesses"]:
				self.data["reviews"]["repeatReviews"]["businesses"].append(decoded["business_id"])

		index="%istar" % decoded["stars"]
		self.data["reviews"][index].append(decoded["business_id"])
		self.data["reviews"]["total"]+=1
		self.data["reviews"]["usefulVotes"]+=decoded["votes"]["useful"]
		self.data["reviews"]["funnyVotes"]+=decoded["votes"]["funny"]
		self.data["reviews"]["usefulVotes"]+=decoded["votes"]["cool"]
