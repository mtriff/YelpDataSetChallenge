#$ -cwd
#$ -j y
#$ -l h_rt=08:00:00

module load python

python strID2index.py businessID.csv userBusinessAssoNoUID.csv > userBusinessNumericAssociation.csv
python strID2index.py userID.csv businessUserAssoNoBID.csv > businessUserNumericAssociation.csv
