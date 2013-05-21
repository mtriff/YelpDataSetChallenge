import sys

def readArray(file):
    with open(file,"r") as fp:
        arr = []
        for line in fp:
           arr.append(line.strip())
    return arr

def linSearch(target,arr):
    for i in range(len(arr)):
        if target == arr[i]:
            return i
    return -1

def binSearch(target,arr):
    lo = 0
    hi = len(arr)-1
    while lo <= hi:
        mid = (lo+hi)/2
	if arr[mid]==target:
	    return mid
	elif arr[mid]<target:
	    lo = mid+1
	else:
	    hi = mid-1
    return -1


def printNumAssoc(file,strID):
    with open(file,"r") as fp:
        for line in fp:
           line = line.strip()
	   IDs = line.split()
	   for ID in IDs:
	       #print binSearch(ID,strID),
	       index = linSearch(ID,strID)
               print index,
	   print

#main

strID =  readArray(sys.argv[1])
printNumAssoc(sys.argv[2],strID)
