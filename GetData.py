temperature = []
longMoment = []
dataFile = open("JPSW-RM-5_1kGChiT.rso", "r")

#Find line containing [Data]
theLine = dataFile.readline()
lineNumber = 1
foundData = False
while foundData == False:
    if "[Data]" in theLine:
        foundData = True
        print("Data")
    else:
        theLine = dataFile.readline()
        lineNumber = lineNumber + 1
print(lineNumber)
   
#Find position of temperature and long moment
theLine = dataFile.readline()
headings = theLine.split(",")
commaCount = 0
for str in headings:
    if str.startswith("Temperature"):
        print("Hello")
        break
    else:
        commaCount = commaCount + 1
print(commaCount)

#Store data for temperature and long moment
theLine = dataFile.readline()
while theLine:
    lineData = theLine.split(",")
    temperature.append(lineData[commaCount])
    longMoment.append(lineData[commaCount + 1])
    theLine = dataFile.readline()
dataFile.close()

#Write data to file
dataWrite = open("temperature.txt", "w")
for i in temperature:
    dataWrite.write(i + "\n")
dataWrite.close()
dataWrite = open("longMoment.txt", "w")
for i in longMoment:
    dataWrite.write(i + "\n")
dataWrite.close()
