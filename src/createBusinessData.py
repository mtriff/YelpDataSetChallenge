import business
import json

def importBusinesses(businessDict):
	businessDataset=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_business.json","r")

	for line in businessDataset:
		currBusiness=business.Business(line)
		businessDict[currBusiness.data["business_id"]]=currBusiness
	return businessDict

def importVisits(businessDict):
	checkinDataset=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_checkin.json","r")
	noBusinessFile=open("/globalscratch/plingras/matt/datasets/businessNotInDataset.json", "w")
	for line in checkinDataset:
		checkinBusiness=json.loads(line.strip())["business_id"]
		if checkinBusiness in businessDict:
			businessDict[checkinBusiness].setVisitTime(line)
		else:
			noBusinessFile.write(line)

	return businessDict

def importReviews(businessDict):
	reviewDataset=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_review.json","r")
	noBusinessFile=open("/globalscratch/plingras/matt/datasets/businessNotInDataset.json", "a")
	for line in reviewDataset:
		reviewBusiness=json.loads(line.strip())["business_id"]
		if reviewBusiness in businessDict:
			businessDict[reviewBusiness].addReview(line)
		else:
			noBusinessFile.write(line)

	return businessDict

def outputBusinessDict(businessDict):
	businessOutput=open("/globalscratch/plingras/matt/datasets/yelpBusinesses.json", "w")
	for item in businessDict.values():
		businessOutput.write(json.dumps(item.data)+"\n")

businessDict={}
outputBusinessDict(importReviews(importVisits(importBusinesses(businessDict))))