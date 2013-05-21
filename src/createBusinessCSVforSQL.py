import json

def processLines():
	readFile=open("/globalscratch/plingras/matt/datasets/yelpBusinesses.json","r")
	businessInfoOut=open("/globalscratch/plingras/matt/forSQL/businessInfo.csv", "w")
	reviewedOut=open("/globalscratch/plingras/matt/forSQL/reviewed.csv", "w")

	for line in readFile:
		lineDict=json.loads(line)
		businessInfoTable(lineDict, businessInfoOut)
		reviewedTable(lineDict, reviewedOut)

def businessInfoTable(line, outFile):
	if 'visitTime' in line:
		checkins=str(sum(line['visitTime'].itervalues()))
	else:
		checkins=0

	lineCSV="'"+line["business_id"]+"' '"+line['name']+"' '"+str(line['reviews']['total'])+"' '"+str(checkins)+"' '"+str(line['stars'])+"' '"+' '.join(line['categories'])+"' '"+line['location']['address'].replace('\n', '<br/>')+"'\n"
	outFile.write(lineCSV.encode('utf-8'))
	
def reviewedTable(line, outFile):
	for reviewer in line['reviews']['1star']:
		outFile.write("'"+reviewer+"' '"+line['business_id']+"'\n")
	for reviewer in line['reviews']['2star']:
		outFile.write("'"+reviewer+"' '"+line['business_id']+"'\n")
	for reviewer in line['reviews']['3star']:
		outFile.write("'"+reviewer+"' '"+line['business_id']+"'\n")
	for reviewer in line['reviews']['4star']:
		outFile.write("'"+reviewer+"' '"+line['business_id']+"'\n")
	for reviewer in line['reviews']['5star']:
		outFile.write("'"+reviewer+"' '"+line['business_id']+"'\n")

processLines()