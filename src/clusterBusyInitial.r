businessOrig = read.table("businessDataArray.csv",header=F,sep=" ")
summary(businessOrig)
col=length(businessOrig[1,])
row=length(businessOrig[,1])
businessNorm=businessOrig
for(i in 1:col)
{
    businessNorm[,i]=businessNorm[,i]/mean(businessNorm[,i])
}
summary(businessNorm)
source("funcMultiClustering.r")
km=bestKmeans(businessNorm,5)
km$centers
km$size
km=bestKmeans(businessNorm,7)
km$centers
km$size
#7 clusters seem best
businessCenters = km$centers
for(i in 1:col)
{
    businessCenters[,i]=businessCenters[,i]*mean(businessOrig[,i])
}
businessCenters
