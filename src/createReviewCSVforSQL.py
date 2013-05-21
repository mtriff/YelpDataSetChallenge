import json

def processLines():
	readFile=open("/globalscratch/plingras/matt/original/yelp_academic_dataset_review.json","r")
	businessInfoOut=open("/globalscratch/plingras/matt/forSQL/reviewInfo.csv", "w")

	for line in readFile:
		lineDict=json.loads(line)
		reviewInfoTable(lineDict, businessInfoOut)

def reviewInfoTable(line, outFile):
	lineCSV='|'+line['review_id']+'| |'+line['user_id']+'| |'+line['business_id']+'| |'+str(line['votes']['funny'])+'| |'+str(line['votes']['useful'])+'| |'+str(line['votes']['cool'])+'| |'+line['date']+'| |'+str(line['stars'])+'| |'+line['text'].replace('\n', '<br>').replace('|', ' ')+'|\n'
	outFile.write(lineCSV.encode('utf-8'))

processLines()
