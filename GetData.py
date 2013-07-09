filePath = "JPSW-RM-5_1kGChiT.rso"
blankPath = "blank_1kG.csv"
tFileName = "temperature.txt"
lmFileName = "longMoment.txt"

for i in range(2):
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
        if filePath != blankPath:
            dataWrite.write(i + "\n")
        else:
            dataWrite.write(i)
    dataWrite.close()
    filePath = blankPath
    tFileName = "blankTemperature.txt"
    lmFileName = "blankLongMoment.txt"


#Read data back into arrays
rTemperature = []
rLongMoment = []
bTemperature = []
bLongMoment = []
dataFile = open("temperature.txt", "r")
theLine = dataFile.readline()
while theLine:
    rTemperature.append(theLine)
    theLine = dataFile.readline()
dataFile = open("longMoment.txt", "r")
theLine = dataFile.readline()
while theLine:
    rLongMoment.append(theLine)
    theLine = dataFile.readline()
dataFile = open("blankTemperature.txt", "r")
theLine = dataFile.readline()
while theLine:
    bTemperature.append(theLine)
    theLine = dataFile.readline()
dataFile = open("blankLongMoment.txt", "r")
theLine = dataFile.readline()
while theLine:
    bLongMoment.append(theLine)
    theLine = dataFile.readline()
dataFile.close()    

#Find nearest +- to data points
matchedLM = []
deletions = 0
startDelete = False
endDelete = False
blankLarger = True
if len(rTemperature) >= len(bTemperature):
    blankLarger = False
    count = 0
    for i in rTemperature:
        i = float(i)
        j = 0
        if i >= float(bTemperature[len(bTemperature)-1]):
            while i < float(bTemperature[j]):
                j = j + 1      
            #Form straight line between points to calculate
            #long moment value at given temperature
            if j != 0:
                x1 = float(bTemperature[j])
                x2 = float(bTemperature[j-1])
                y1 = float(bLongMoment[j])
                y2 = float(bLongMoment[j-1])
                m = (y2-y1)/(x2-x1)
                x = i
                y = (((y2-y1)/(x2-x1))*(x-x1))+y1
                matchedLM.append(y)
            else:
                deletions = deletions + 1
                startDelete = True
        else:
            deletions = deletions + 1
            endDelete = True
        count = count + 1    

    #Write data to file
    dataWrite = open("matchedBlankData.txt", "w")
    lmCount = 0
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(rTemperature) - deletions + 1):
        dataWrite.write(repr(float(bTemperature[i])) + "," + repr(matchedLM[lmCount]) + "\n")
        lmCount = lmCount + 1
    dataWrite.close()
    dataWrite = open("matchedRecordedData.txt", "w")
    lmCount = 0
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(rTemperature) - deletions + 1):
        dataWrite.write(repr(float(rTemperature[i])) + "," + repr(rLongMoment[i]) + "\n")
        lmCount = lmCount + 1
    dataWrite.close()
else:
    count = 0
    for i in bTemperature:
        i = float(i)
        j = 0
        if i >= float(rTemperature[len(rTemperature)-1]):
            while i < float(rTemperature[j]):
                j = j + 1      
            #Form straight line between points to calculate
            #long moment value at given temperature
            if j != 0:
                x1 = float(rTemperature[j])
                x2 = float(rTemperature[j-1])
                y1 = float(rLongMoment[j])
                y2 = float(rLongMoment[j-1])
                m = (y2-y1)/(x2-x1)
                x = i
                y = (((y2-y1)/(x2-x1))*(x-x1))+y1
                matchedLM.append(y)
            else:
                deletions = deletions + 1
                startDelete = True
        else:
            deletions = deletions + 1
            endDelete = True
        count = count + 1    

    #Write data to file
    dataWrite = open("matchedRecordedData.txt", "w")
    lmCount = 0
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(bTemperature) - deletions + 1):
        dataWrite.write(repr(float(bTemperature[i])) + "," + repr(matchedLM[lmCount]) + "\n")
        lmCount = lmCount + 1
    dataWrite.close()
    dataWrite = open("matchedBlankData.txt", "w")
    startIndex = 0
    if startDelete == True:
        startIndex = 1
    for i in range(startIndex, len(bTemperature) - deletions + 1):
        dataWrite.write(repr(float(bTemperature[i])) + "," + (bLongMoment[i]))
    dataWrite.close()


