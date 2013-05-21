import json

def processLines():
	readFile=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_user.json","r")
	businessInfoOut=open("/globalscratch/plingras/matt/forSQL/reviewerInfo.csv", "w")

	for line in readFile:
		lineDict=json.loads(line)
		reviewerInfoTable(lineDict, businessInfoOut)

def reviewerInfoTable(line, outFile):
	lineCSV='|'+line['user_id']+'| |'+line['name']+'| |'+str(line['review_count'])+'| |'+str(line['votes']['funny'])+'| |'+str(line['votes']['useful'])+'| |'+str(line['votes']['cool'])+'| |'+str(line['average_stars'])+'|\n'
	outFile.write(lineCSV.encode('utf-8'))

processLines()
