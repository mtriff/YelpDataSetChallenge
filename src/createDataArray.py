import numpy
from numpy import array
import json


def createRawData(file):
	inFile=open(file, "r")

	for line in inFile:
		decoded=json.loads(line.strip())

		if "user_id" in decoded.keys():
			idType="user_id"
			#rawFile=open("/globalscratch/plingras/matt/analysis/businessesRaw.out", "w")
		elif "business_id" in decoded.keys():
			idType="business_id"
			#rawFile=open("/globalscratch/plingras/matt/analysis/usersRaw.out", "w")
		else:
			raise Exception("Unable to find user or business data type in input file")

		if idType=="business_id":
			currObject=numpy.array([decoded[idType],decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"], 
									100.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"]])
		else:
			currObject=numpy.array([decoded[idType],decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"], 
									100.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"],
									100.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"],
									(decoded["reviews"]["funnyVotes"]+decoded["reviews"]["usefulVotes"]+decoded["reviews"]["coolVotes"])])
                #rawFile.write(currObject)
                for i in range(len(currObject)):
			print currObject[i],
                print

#main 
#Usage: python createDataArray.py | sort > businessDataArrayID.csv
#createRawData("/globalscratch/plingras/matt/datasets/yelpBusinesses.json")
#Usage: python createDataArray.py | sort > userDataArrayID.csv
createRawData("/globalscratch/plingras/matt/datasets/yelpUsers.json")
