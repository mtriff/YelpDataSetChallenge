import numpy
from numpy import array
import math

class DaviesBouldinIndex:
	"""DaviesBouldinIndex
		Given the output from numpy.vq.kmeans2 and the original data
		that was used in calculating the centroids by kmeans, this class 
		will calculate the Davies-Bouldin Index for the clusters.

		After initialization, the DB index can be obtained via the getDBindex() method"""
	def __init__(self, centroid, label, data):
		(_, self.numOfDimensions)=centroid.shape
		self.numOfClusters=len(centroid.tolist())
		self.data=data
		self.label=label
		self.centroid=centroid

		#Create list of empty lists
		self.clusterObjects=[list([]) for _ in range(self.numOfClusters)]

		#separate the data objects into lists with the rest of their cluster
		for dataObject, clusterIndex in zip(data, label):
			self.clusterObjects[clusterIndex].append(dataObject)

		self.getDistanceBetweenCentroids()
		self.getClusterDensities()
		self.calculate()

	def getDBindex(self):
		return self.DBindex

	#Distance between two data or centroid objects
	def distance(self, item1, item2):
		tempDistance=0
		for var1, var2 in zip(item1, item2):
			tempDistance+=((var1-var2)**2)
		return math.sqrt(tempDistance)

	#Calculate the distances between each of the centroids
	def getDistanceBetweenCentroids(self):
		self.clusterDistance=[list([]) for _ in range(self.numOfClusters)]
		for clusterIdx1 in range(0, self.numOfClusters):
			for clusterIdx2 in range(0, self.numOfClusters):
				if clusterIdx1==clusterIdx2:
					self.clusterDistance[clusterIdx1].append(0)
				else:
					self.clusterDistance[clusterIdx1].append(
						self.distance(self.centroid[clusterIdx1], self.centroid[clusterIdx2]))

	#Find the density or scatter for each cluster
	def getClusterDensities(self):
		self.clusterDensity=[0 for _ in range(self.numOfClusters)]
		for clusterIndex in range(0,self.numOfClusters):
			for dataObject in self.clusterObjects[clusterIndex]:
				currDist=self.distance(self.centroid[clusterIndex], dataObject)
				self.clusterDensity[clusterIndex]+=currDist
			self.clusterDensity[clusterIndex]/=len(self.clusterObjects[clusterIndex])

	def calculate(self):
		self.R=[list([]) for _ in range(self.numOfClusters)]
		self.Rmax=[0 for _ in range(self.numOfClusters)]
		self.DBindex=0
		for clusterIdx1 in range(0, self.numOfClusters):
			for clusterIdx2 in range(0, self.numOfClusters):
				if clusterIdx1==clusterIdx2:
					self.R[clusterIdx1].append(0)
				else:
					self.R[clusterIdx1].append((self.clusterDensity[clusterIdx1]
														+self.clusterDensity[clusterIdx2])/
															self.clusterDistance[clusterIdx1][clusterIdx2])
					if(self.Rmax[clusterIdx1]<self.R[clusterIdx1][clusterIdx2]):
						self.Rmax[clusterIdx1]=self.R[clusterIdx1][clusterIdx2]
			self.DBindex+=self.Rmax[clusterIdx1]
		self.DBindex/=self.numOfClusters