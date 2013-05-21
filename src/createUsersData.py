import user
import json


def importUsers(usersDict):
	userDataset=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_user.json","r")
	usersDict={}

	for line in userDataset:
		currUser=user.User(line)
		usersDict[currUser.data["user_id"]]=currUser

	return usersDict

def importReviews(usersDict):
	reviewDataset=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_review.json","r")
	noUserFile=open("/globalscratch/plingras/matt/datasets/userNotInDataset.json","w")
	for line in reviewDataset:
		reviewUser=json.loads(line.strip())["user_id"]
		if reviewUser in usersDict:
			usersDict[reviewUser].addReview(line)
		else:
			noUserFile.write(line)
			pass

	return usersDict

def outputUsersDict(usersDict):
	userOutput=open("/globalscratch/plingras/matt/datasets/yelpUsers.json","w")

	for item in usersDict.values():
		userOutput.write(json.dumps(item.data)+"\n")

usersDict={}
outputUsersDict(importReviews(importUsers(usersDict)))
