#$ -cwd
#$ -j y
#$ -l h_rt=08:00:00

module load python

#uncomment business line from main in createDataArray.py (comment out user line)
python createDataArray.py | sed 's/ $//' | sort >businessDataArrayID.csv
#uncomment user line from main in createDataArray.py (comment out business line)
python createDataArray.py | sed 's/ $//' | sort >userDataArrayID.csv

#strip ID from the data arrays
awk '{for(i = 2; i <= NF; i++) printf("%.4f ",$i); printf("\n")}' businessDataArrayID.csv >  businessDataArray.csv
awk '{for(i = 2; i <= NF; i++) printf("%.4f ",$i); printf("\n")}' userDataArrayID.csv >  userDataArray.csv

#Collect user and businessIDs
awk '{print($1)}' businessDataArrayID.csv >  businessID.csv
awk '{print($1)}' userDataArrayID.csv >  userID.csv

#uncomment business line from main in createAssociation.py (comment out user line)
python createAssociation.py | sed 's/\]//g' | sed 's/\[//g' | sed "s/u'//g" | sed 's/,//g' | sed "s/'//g" | sed 's/  */ /g' | sort > businessUserAssociation.csv
#uncomment user line from main in createAssociation.py (comment out business line)
python createAssociation.py | sed 's/\]//g' | sed 's/\[//g' | sed "s/u'//g" | sed 's/,//g' | sed "s/'//g" | sed 's/  */ /g' | sort > userBusinessAssociation.csv

#Collect user and businessIDs
awk '{print($1)}' businessUserAssociation.csv >  businessID1.csv
awk '{print($1)}' userBusinessAssociation.csv >  userID1.csv

# Make sure that the IDs are in the same order
cmp businessID.csv businessID1.csv
cmp userID.csv userID1.csv

#strip userID from user->business
awk '{for(i = 2; i <= NF; i++) printf("%s ",$i); printf("\n")}' userBusinessAssociation.csv >  userBusinessAssoNoUID.csv
awk '{for(i = 2; i <= NF; i++) printf("%s ",$i); printf("\n")}' businessUserAssociation.csv >  businessUserAssoNoBID.csv

python strID2index.py businessID.csv userBusinessAssoNoUID.csv > userBusinessNumericAssociation.csv
python strID2index.py userID.csv businessUserAssoNoBID.csv > businessUserNumericAssociation.csv

