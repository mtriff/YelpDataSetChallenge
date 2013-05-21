import numpy
from numpy import array
import json

def createDataArray(file):
	inFile=open(file, "r")

	sumValues=[0,0,0,0,0,0,0]
	count=0

	for line in inFile:
		decoded=json.loads(line.strip())

		if "user_id" in decoded.keys():
			idType="user_id"
		elif "business_id" in decoded.keys():
			idType="business_id"
		else:
			raise Exception("Unable to find user or business data type in input file")

		if idType=="business_id":
			count+=1
			sumValues[0]+=decoded["reviews"]["total"]
			sumValues[1]+=len(decoded["reviews"]["1star"])
			sumValues[2]+=len(decoded["reviews"]["2star"])
			sumValues[3]+=len(decoded["reviews"]["3star"])
			sumValues[4]+=len(decoded["reviews"]["4star"])
			sumValues[5]+=len(decoded["reviews"]["5star"])

			#array style will be [#reviews,*,**,***,****,*****]
			currObject=numpy.array([decoded["reviews"]["total"],
									len(decoded["reviews"]["1star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["2star"])*1.0/decoded["reviews"]["total"], 
									len(decoded["reviews"]["3star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["4star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["5star"])*1.0/decoded["reviews"]["total"]])
			if 'dataArray' not in locals():
				dataArray=currObject
			else:
				dataArray=numpy.vstack((dataArray, currObject))
		else:
			count+=1
			sumValues[0]+=decoded["reviews"]["total"]
			sumValues[1]+=len(decoded["reviews"]["1star"])
			sumValues[2]+=len(decoded["reviews"]["2star"])
			sumValues[3]+=len(decoded["reviews"]["3star"])
			sumValues[4]+=len(decoded["reviews"]["4star"])
			sumValues[5]+=len(decoded["reviews"]["5star"])
			sumValues[6]+=(decoded["reviews"]["funnyVotes"]+decoded["reviews"]["usefulVotes"]+decoded["reviews"]["coolVotes"])

			#array style will be [#reviews,*,**,***,****,*****,votes]
			currObject=numpy.array([decoded["reviews"]["total"],
									len(decoded["reviews"]["1star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["2star"])*1.0/decoded["reviews"]["total"], 
									len(decoded["reviews"]["3star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["4star"])*1.0/decoded["reviews"]["total"],
									len(decoded["reviews"]["5star"])*1.0/decoded["reviews"]["total"],
									(decoded["reviews"]["funnyVotes"]+decoded["reviews"]["usefulVotes"]+decoded["reviews"]["coolVotes"])])
			if 'dataArray' not in locals():
				dataArray=currObject
			else:
				dataArray=numpy.vstack((dataArray, currObject))

	if idType=="business_id":
		sumValues.pop()

	print "%s\n" % idType

	averages=[]
	for value in sumValues:
		averages.append(value*1.0/count)

	return dataArray, averages

def analyze(file):
	dataArray, averages=createDataArray(file)
	#percent2=numpy.percentile(dataArray, 2.5, axis=0)
	#percent16=numpy.percentile(dataArray, 16, axis=0)
	#percent50=numpy.percentile(dataArray, 50, axis=0)
	#percent84=numpy.percentile(dataArray, 84, axis=0)
	#percent97=numpy.percentile(dataArray, 97.5, axis=0)
	
	if(len(averages)==6):
		averagesFile=open("/globalscratch/plingras/matt/analysis/businessesAverages.out", "w")
		analysisFile=open("/globalscratch/plingras/matt/analysis/businessesAnalysis.out","w")
	else:
		averagesFile=open("/globalscratch/plingras/matt/analysis/usersAverages.out", "w")
		analysisFile=open("/globalscratch/plingras/matt/analysis/usersAnalysis.out","w")

	averagesDict={"averages":averages}
  	averagesFile.write(json.dumps(averagesDict))
	#analysisFile.write(percent2.tolist()+"\t-2 Standard Deviations (2.5%)")
	#analysisFile.write(percent16.tolist()+"\t-1 Standard Deviations (16%)")
	#analysisFile.write(percent50.tolist()+"\tMedian (50%)")7	#analysisFile.write(percent84.tolist()+"\t+1 Standard Deviations (84%)")
	#analysisFile.write(percent97.tolist()+"\t+2 Standard Deviations (97.5%)")
