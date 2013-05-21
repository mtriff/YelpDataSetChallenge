bestKmeans <- function(mat,k)
{
    bestKM =  kmeans(mat,k,1000)
    minSS = bestKM$tot.withinss
    for(i in 1:10)
    {
        km <- kmeans(mat,k,1000)
        if(km$tot.withinss < minSS)
        {
             bestKM =  km
             minSS = bestKM$tot.withinss
        }
    }
    bestKM
}

rangeKtable <- function(mat,minK,maxK)
{
    km.ss <- array(minK:maxK)
    for(k in minK:maxK)
    {
        km.ss[k-minK+1] <- kmeans(mat,k,100)$tot.withinss
    }
    km.ss
}

