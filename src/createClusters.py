import cluster

#print "Creating Business Clusters"
cluster.findBestCluster("/globalscratch/plingras/matt/datasets/yelpBusinesses.json")
#print "Completed Business Clusters"
#print "Creating User Clusters"
cluster.findBestCluster("/globalscratch/plingras/matt/datasets/yelpUsers.json")
#print "Completed User Clusters"
