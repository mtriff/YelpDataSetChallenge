#!/usr/bin/python

#Usage: python createDynamicRep.py userDataArray.csv businessClusters.csv userBusinessNumericAssociation.csv > userDynamicArray.csv
#Usage: python createDynamicRep.py businessDataArray.csv userClusters.csv businessUserNumericAssociation.csv > businessDynamicArray.csv
import sys

K = 7

def readIntMatrix(file):
    with open(file,"r") as staticFile:
        arr = []
        for line in staticFile:
            line = line.split()
	    if line:
	        line = [int(i) for i in line]
	        arr.append(line)
    return arr

def readFloatMatrix(file):
    with open(file,"r") as staticFile:
        arr = []
        for line in staticFile:
            line = line.split()
	    if line:
	        line = [float(i) for i in line]
	        arr.append(line)
    return arr

def printArray(array):
    for i in range(len(array)):
        for j in range(len(array[0])):
            print array[i][j]," ",
        print
  
def printDynamic(staticArray, membershipArray, assocArray):
    for i in range(len(staticArray)):
        dynamicArray = [0.0,0.0,0.0,0.0,0.0,0.0,0.0]
        for j in range(len(assocArray[i])):
            other =  int(assocArray[i][j])
            if other != -1:
                m = int(membershipArray[other][0])-1
	        dynamicArray[m]+=1
	total=sum(dynamicArray)
        for j in range(len(staticArray[0])):
	    print staticArray[i][j],
        for j in range(len(dynamicArray)):
            if total != 0:
	        print 100.0*dynamicArray[j]/total,
	        #print 10.0*dynamicArray[j]/total,
            else:
                print 0,
	print 
    return staticArray

staticArray = readFloatMatrix(sys.argv[1])
membershipArray = readIntMatrix(sys.argv[2])
#printArray(membershipArray)
assocArray = readIntMatrix(sys.argv[3])
printDynamic(staticArray, membershipArray, assocArray)
