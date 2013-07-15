from DataHandling import getSampleMass

sampleMass = getSampleMass("upload/rawData.txt")

fileWrite = open("upload/config.txt", "r+")
theLine = fileWrite.readline()
foundData = False
while foundData == False:
    if "Molecular" in theLine:
        foundData = True
    else:
        theLine = fileWrite.readline()
theData = theLine.split(":")
fileWrite.write(theData[0] + ": " + sampleMass + "\n")
fileWrite.close()
