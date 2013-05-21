import numpy
from numpy import array
import json


def createAssociationData(file):
	inFile=open(file, "r")

	for line in inFile:
		decoded=json.loads(line.strip())

		if "user_id" in decoded.keys():
			idType="user_id"
		elif "business_id" in decoded.keys():
			idType="business_id"
		else:
			raise Exception("Unable to find user or business data type in input file")

	        currObject=[]
                currObject.append(decoded[idType])
		currObject.append(decoded["reviews"]["1star"])
		currObject.append(decoded["reviews"]["2star"])
		currObject.append(decoded["reviews"]["3star"])
		currObject.append(decoded["reviews"]["4star"])
		currObject.append(decoded["reviews"]["5star"])
                for i in range(len(currObject)):
			print currObject[i],
                print

#main 
#Usage:  python createAssociation.py | sed 's/\]//g' | sed 's/\[//g' | sed "s/u'//g" | sed 's/,//g' | sed "s/'//g" | sed 's/  */ /g' | sort > businessUserAssociation.csv
createAssociationData("/globalscratch/plingras/matt/datasets/yelpBusinesses.json")
#Usage:  python createAssociation.py | sed 's/\]//g' | sed 's/\[//g' | sed "s/u'//g" | sed 's/,//g' | sed "s/'//g" | sed 's/  */ /g' | sort > userBusinessAssociation.csv
#createAssociationData("/globalscratch/plingras/matt/datasets/yelpUsers.json")
