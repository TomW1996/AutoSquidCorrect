import os

def getInformation(index):
    theData = []
    dataFile = open("upload/config.txt", "r")
    for i in range(10):
        theLine = dataFile.readline()
        theData.append(theLine.split(":")[1].strip())
    return theData[index]

def getSampleMass(filePath):
    dataFile = open(filePath, "r")
    theLine = dataFile.readline()
    foundData = False
    while foundData == False:
        if "WEIGHT" in theLine:
            foundData = True
        else:
            theLine = dataFile.readline()
    sampleMass = theLine.split(",")[2]
    return sampleMass

def getData(filePath, tFileName, lmFileName, dataX, dataY):
    #Find line containing [Data]
    dataFile = open(filePath, "r")
    theLine = dataFile.readline()
    foundData = False
    while foundData == False:
        if "[Data]" in theLine:
            foundData = True
        else:
            theLine = dataFile.readline()

    #Find position of temperature and long moment
    theLine = dataFile.readline()
    headings = theLine.split(",")
    tCount = 0
    lmCount = 0
    for str in headings:
        if str.lower().startswith(dataX):
            break
        else:
            tCount = tCount + 1
    for str in headings:
        if str.lower().startswith(dataY):
            break
        else:
            lmCount = lmCount + 1        

    #Store data for temperature and long moment
    temperatureData = []
    longMomentData = []
    theLine = dataFile.readline()
    while theLine:
        lineData = theLine.split(",")
        temperatureData.append(lineData[tCount])
        longMomentData.append(lineData[lmCount])
        theLine = dataFile.readline()
    dataFile.close()

    #Write data to file
    dataWrite = open(tFileName, "w")
    for i in temperatureData:
        dataWrite.write(i + "\n")
    dataWrite.close()
    dataWrite = open(lmFileName, "w")
    for i in longMomentData:
        if tFileName == "temperature.txt":
            dataWrite.write(i + "\n")
        else:
            dataWrite.write(i)
    dataWrite.close()

def readData(filePath):
    #Read data back into arrays
    theArray = []
    dataFile = open(filePath, "r")
    theLine = dataFile.readline()
    while theLine:
        theArray.append(theLine)
        theLine = dataFile.readline()
    dataFile.close()
    return theArray

def restoreArray(filePath, index):
    #Set data arrays to use matched data
    theArray = []
    dataFile = open(filePath, "r")
    theLine = dataFile.readline()
    while theLine:
        data = theLine.split(",")
        theArray.append(data[index])
        theLine = dataFile.readline()
    dataFile.close()
    return theArray

def deleteFiles(eicoUsed):
    os.remove("temperature.txt")
    os.remove("longMoment.txt")
    os.remove("blankTemperature.txt")
    os.remove("blankLongMoment.txt")
    os.remove("matchedRecordedData.txt")
    os.remove("matchedBlankData.txt")
    if(eicoUsed == True):
        os.remove("eicoTemperature.txt")
        os.remove("eicoLongMoment.txt")
        os.remove("matchedEicoData.txt")
