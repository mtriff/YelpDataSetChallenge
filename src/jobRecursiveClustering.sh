#$ -cwd
#$ -j y
#$ -l h_rt=08:00:00

module load python
module load r

# Cluster businesses with static data
R --slave -f clusterGeneric.r businessDataArray.csv businessCenters.csv businessClusters.csv businessSize.csv

# start the loop
for((i = 0; i < 20; i++))
do
	#create dynamic rep for users
	python createDynamicRep.py userDataArray.csv businessClusters.csv userBusinessNumericAssociation.csv > userDynamicArray.csv

	#cluster users with dynamic rep
	R --slave -f clusterGeneric.r userDynamicArray.csv userCenters.csv userClusters.csv userSize.csv

	#create dynamic rep for business
        python createDynamicRep.py businessDataArray.csv userClusters.csv businessUserNumericAssociation.csv > businessDynamicArray.csv

	#cluster business with dynamic rep
        R --slave -f clusterGeneric.r businessDynamicArray.csv businessCenters.csv businessClusters.csv businessSize.csv
done
