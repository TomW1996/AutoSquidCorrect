from Main import *

validationPassed = True
theData = []
dataFile = open("config.txt", "r")
for i in range(8):
    theLine = dataFile.readline()
    data = theLine.split(":")[1].strip()
    if data == "":
        validationPassed = False      
    else:
        theData.append(data)
if validationPassed == True:
    for i in range(3,7):
        try:
            float(theData[i])
        except ValueError:
            validationPassed = False
if validationPassed == True:
    if (theData[2] == "Data_Files/" and theData[3] == 0 and theData[4] == 0) or ((theData[2].startswith("Data_Files/") and len(theData[2]) > len("Data_Files/")) and theData[3] != 0 and theData[4] != 0):
        run()
