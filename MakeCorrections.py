def getData(filePath, tFileName, lmFileName):
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
        if str.startswith("Temperature"):
            break
        else:
            tCount = tCount + 1
    for str in headings:
        if str.startswith("Long Moment"):
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
        if tFileName != "blankTemperature.txt":
            dataWrite.write(i + "\n")
        else:
            dataWrite.write(i)
    dataWrite.close()

getData("JPSW-RM-5_1kGChiT.rso", "temperature.txt", "longMoment.txt")
getData("blank_1kG.csv","blankTemperature.txt", "blankLongMoment.txt")

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

rTemperature = readData("temperature.txt")
rLongMoment = readData("longMoment.txt")
bTemperature = readData("blankTemperature.txt")
bLongMoment = readData("blankLongMoment.txt")

def matchDataPoints(tempA, lmA, tempB, lmB, filePathA, filePathB):
    matchedLM = []
    deletions = 0
    startDelete = False
    count = 0
    for i in tempA:
        i = float(i)
        j = 0
        if i >= float(tempB[len(tempB)-1]):
            while i < float(tempB[j]):
                j = j + 1      
            #Form straight line between points to calculate
            #long moment value at given temperature
            if j != 0:
                x1 = float(tempB[j])
                x2 = float(tempB[j-1])
                y1 = float(lmB[j])
                y2 = float(lmB[j-1])
                m = (y2-y1)/(x2-x1)
                x = i
                y = (((y2-y1)/(x2-x1))*(x-x1))+y1
                matchedLM.append(y)
            else:
                deletions = deletions + 1
                startDelete = True
        else:
            deletions = deletions + 1
        count = count + 1
        
    #Write data to file
    dataWrite = open(filePathA, "w")
    lmCount = 0
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(tempA) - deletions + 1):
        dataWrite.write(repr(float(tempA[i])) + "," + repr(matchedLM[lmCount]) + "\n")
        lmCount = lmCount + 1
    dataWrite.close()   
    dataWrite = open(filePathB, "w")
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(tempA) - deletions + 1):
        dataWrite.write(repr(float(tempA[i])) + "," + (lmA[i]))
    dataWrite.close()

if len(rTemperature) >= len(bTemperature):
    matchDataPoints(rTemperature, rLongMoment, bTemperature, bLongMoment, "matchedBlankData.txt", "matchedRecordedData.txt")
else:
    matchDataPoints(bTemperature, bLongMoment, rTemperature, rLongMoment, "matchedRecordedData.txt", "matchedBlankData.txt") 

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

rTemperature = restoreArray("matchedRecordedData.txt", 0)
rLongMoment = restoreArray("matchedRecordedData.txt", 1)
bTemperature = restoreArray("matchedBlankData.txt", 0)
bLongMoment = restoreArray("matchedBlankData.txt", 1)

#Correct data by subtracting blank data from recorded data
correctedLongMoment = []
count = 0
for i in rLongMoment:
    correctedLongMoment.append(float(i) - float(bLongMoment[count]))
    count = count + 1

#Write corrected data to file
dataWrite = open("correctedData.txt", "w")
count = 0
for i in correctedLongMoment:
    dataWrite.write(rTemperature[count] + "," + repr(i) + "\n")
    count = count + 1
dataWrite.close()
