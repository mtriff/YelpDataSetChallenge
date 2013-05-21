import numpy
from numpy import array
from scipy.cluster.vq import vq, kmeans2
from daviesBouldinIndex import DaviesBouldinIndex 
import json
import warnings

def findBestCluster(file):
	idArray, dataArray=createDataArray(file)

	bestCentroids, minDB, bestMapping=cluster(dataArray)
	for iter in range(0,10):
		centroids, db, mapping=cluster(dataArray)
		if db<minDB:
			bestCentroids=centroids
			bestMapping=mapping
			minDB=db

	record(idArray, dataArray, minDB, bestMapping, bestCentroids)

def cluster(dataArray):
	warnings.filterwarnings('error')
	bestKmeans=None

	#Gross code to handle warning from numpy for an empty cluster
	while bestKmeans is None:
		try:
			bestKmeans, bestMapping=kmeans2(dataArray, 5)
		except:
			pass
	minDB=DaviesBouldinIndex(bestKmeans, bestMapping, dataArray).getDBindex()
	for numClusters in range(5,11):
		kmeans=None
		while kmeans is None:
			try:
				kmeans, mapping=kmeans2(dataArray, numClusters)
			except:
				pass

		#print "Valid cluster created with numClusters:%i." % numClusters

		db=DaviesBouldinIndex(kmeans, mapping, dataArray).getDBindex()
		if db<minDB:
			minDB=db
			bestKmeans=kmeans
			bestMapping=mapping

	return bestKmeans, minDB, bestMapping

def createDataArray(file):
	inFile=open(file, "r")
	idArray=[]

	for line in inFile:
		decoded=json.loads(line.strip())

		if "user_id" in decoded.keys():
			idType="user_id"
			averagesFile=open("/globalscratch/plingras/matt/analysis/usersAverages.out", "r")
			averages=json.loads(averagesFile.read())["averages"]
		elif "business_id" in decoded.keys():
			idType="business_id"
			averagesFile=open("/globalscratch/plingras/matt/analysis/businessesAverages.out", "r")
			averages=json.loads(averagesFile.read())["averages"]
		else:
			raise Exception("Unable to find user or business data type in input file")

		idArray.append(decoded[idType])

		if idType=="business_id":
			#array style will be [#reviews,*,**,***,****,*****]
			currObject=numpy.array([(decoded["reviews"]["total"]/averages[0])*100,
									((1.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"])/averages[1])*100,
									((1.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"])/averages[2])*100, 
									((1.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"])/averages[3])*100,
									((1.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"])/averages[4])*100,
									((1.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"])/averages[5])*100])

			"""currObject=numpy.array([(decoded["reviews"]["total"]/averages[0]),
									((1.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"])), 
									((1.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"]))])
                       """

			if 'dataArray' not in locals():
				dataArray=currObject
			else:
				dataArray=numpy.vstack((dataArray, currObject))
		else:
			#array style will be [#reviews,*,**,***,****,*****,votes]
			currObject=numpy.array([(decoded["reviews"]["total"]/averages[0])*100,
									((1.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"])/averages[1])*100,
									((1.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"])/averages[2])*100, 
									((1.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"])/averages[3])*100,
									((1.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"])/averages[4])*100,
									((1.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"])/averages[5])*100,
									(((decoded["reviews"]["funnyVotes"]+decoded["reviews"]["usefulVotes"]+decoded["reviews"]["coolVotes"])/averages[6])*100)])

			"""currObject=numpy.array([(decoded["reviews"]["total"]/averages[0]),
									((1.0*len(decoded["reviews"]["1star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["2star"])/decoded["reviews"]["total"])), 
									((1.0*len(decoded["reviews"]["3star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["4star"])/decoded["reviews"]["total"])),
									((1.0*len(decoded["reviews"]["5star"])/decoded["reviews"]["total"])),
									(((decoded["reviews"]["funnyVotes"]+decoded["reviews"]["usefulVotes"]+decoded["reviews"]["coolVotes"])))])

			"""
			if 'dataArray' not in locals():
				dataArray=currObject
			else:
				dataArray=numpy.vstack((dataArray, currObject))
	#print "Created dataArray."
	return idArray, dataArray

def record(idArray, dataArray, minDB, bestMapping, bestCentroids):
	#Check y-dimension of array, x will be 5 for the business array
	(_, y)=dataArray.shape
	if y==6:
		staticData=open("/globalscratch/plingras/matt/clusters/businessStaticData.json", "w")
		centroidFile=open("/globalscratch/plingras/matt/clusters/businessCentroids.json", "w")
	else:
		staticData=open("/globalscratch/plingras/matt/clusters/userStaticData.json", "w")
		centroidFile=open("/globalscratch/plingras/matt/clusters/userCentroids.json", "w")

	#iterate over centroid file, putting it into a json object to write to file, include minDB value
	centroidDict={"numCentroid":1.0*len(bestCentroids.tolist()),"DBindex":minDB,"centroids":bestCentroids.tolist()}
	centroidFile.write(json.dumps(centroidDict))

	#iterate over idArray, dataArray and bestMapping, creating json objects and writing to file
	for itemId, dataPoint, dataMap in zip(idArray, dataArray.tolist(), bestMapping.tolist()):
		currJSON={"id":itemId, "data":dataPoint, "centroidIndex":dataMap}
		staticData.write(json.dumps(currJSON)+"\n")
