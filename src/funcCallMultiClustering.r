s=read.table("syn.csv",header=F,sep=',')
s
tot.withinssarray = multiKmeans(s,2,7)
tot.withinssarray
tot.withinssarray = multiKmeans(s,2,20)
tot.withinssarray
plot(tot.withinssarray)
history(7)

