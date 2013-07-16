from DataHandling import getSampleMass
import os
import sys

sampleMass = getSampleMass("upload/rawData.txt").strip()

fileRead = open("upload/config.txt", "r")
fileWrite = open("upload/tempConfig.txt", "w")
theLine = fileRead.readline()
while theLine:
    if "Molecular" in theLine:
        foundData = True
        theData = theLine.split(":")
        fileWrite.write(theData[0] + ": " + sampleMass + "\n")
        theLine = fileRead.readline()
    else:
        fileWrite.write(theLine)
        theLine = fileRead.readline()
fileWrite.close()
fileRead.close()

os.remove("upload/config.txt")
fileRead = open("upload/tempConfig.txt", "r")
fileWrite = open("upload/config.txt", "w")
theLine = fileRead.readline()
while theLine:
    fileWrite.write(theLine)
    theLine = fileRead.readline()
fileWrite.close()
fileRead.close()
os.remove("upload/tempConfig.txt")
print(sampleMass)
