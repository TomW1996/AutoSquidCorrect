import sys
sampleMass = sys.argv[1]


fileRead = open("upload/config.txt", "r")
fileWrite = open("upload/tempConfig.txt", "w")
theLine = fileRead.readline()
while theLine:
    if "Eicosane" in theLine:
        if "Sample" in theLine:
            theData = theLine.split(":")
            fileWrite.write(theData[0] + ": " + sampleEico + "\n")
            theLine = fileRead.readline()
        if "Blank" in theLine:
            theData = theLine.split(":")
            fileWrite.write(theData[0] + ": " + blankEico + "\n")
            theLine = fileRead.readline()
    if "Molecular" in theLine:
        theData = theLine.split(":")
        fileWrite.write(theData[0] + ": " + sampleMass + "\n")
        theLine = fileRead.readline()
    if "Compound" in theLine:
        theData = theLine.split(":")
        fileWrite.write(theData[0] + ": " + molWeight + "\n")
        theLine = fileRead.readline()
    if "Pascal" in theLine:
        theData = theLine.split(":")
        fileWrite.write(theData[0] + ": " + pascalValue + "\n")
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
