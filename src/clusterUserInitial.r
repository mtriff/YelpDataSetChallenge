userOrig = read.table("userDataArray.csv",header=F,sep=" ")
summary(userOrig)
col=length(userOrig[1,])
row=length(userOrig[,1])
userNorm=userOrig
for(i in 1:col)
{
    userNorm[,i]=userNorm[,i]/mean(userNorm[,i])
}
summary(userNorm)
km=bestKmeans(userNorm,5)
km$centers
km$size
km=bestKmeans(userNorm,7)
km$centers
km$size
#7 clusters seem best
userCenters = km$centers
for(i in 1:col)
{
    userCenters[,i]=userCenters[,i]*mean(userOrig[,i])
}
userCenters
