from DataHandling import *
from Matching import *

#Get settings from config file
rFilePath = getInformation(0)
bFilePath = getInformation(1)
eFilePath = getInformation(2)
compoundEico = float(getInformation(3))
testEico = float(getInformation(4))
molecularWeight = float(getInformation(5))
compoundWeight = float(getInformation(6))
dataX = getInformation(7).lower()
dataY = getInformation(8).lower()
pascalValue = getInformation(9)

#Get data from data files
getData(rFilePath, "temperature.txt", "longMoment.txt", dataX, dataY)
getData(bFilePath,"blankTemperature.txt", "blankLongMoment.txt", dataX, dataY)
getData(eFilePath, "eicoTemperature.txt", "eicoLongMoment.txt", dataX, dataY)

#Store different data in separate arrays
rTemperature = readData("temperature.txt")
rLongMoment = readData("longMoment.txt")
bTemperature = readData("blankTemperature.txt")
bLongMoment = readData("blankLongMoment.txt")
eTemperature = readData("eicoTemperature.txt")
eLongMoment = readData("eicoLongMoment.txt")

#Run matchings algorithm and write results to file
if len(rTemperature) >= len(bTemperature) and len(rTemperature) >= len(eTemperature):
    matchDataPoints(rTemperature, rLongMoment, bTemperature, bLongMoment, "matchedBlankData.txt", "matchedRecordedData.txt", 0)
    matchDataPoints(rTemperature, rLongMoment, eTemperature, eLongMoment, "matchedEicoData", "matchedRecordedData", 1)
elif len(bTemperature) >= len(rTemperature) and len(bTemperature) >= len(eTemperature):
    matchDataPoints(bTemperature, bLongMoment, rTemperature, rLongMoment, "matchedRecordedData.txt", "matchedBlankData.txt", 0)
    matchDataPoints(bTemperature, bLongMoment, eTemperature, eLongMoment, "matchedEicoData.txt", "matchedBlankData.txt", 1)
else:
    matchDataPoints(eTemperature, eLongMoment, rTemperature, rLongMoment, "matchedRecordedData.txt", "matchedEicoData.txt", 0)
    matchDataPoints(bTemperature, bLongMoment, eTemperature, eLongMoment, "matchedBlankData.txt", "matchedEicoData.txt", 1)

#Fill arrays with matched data
rTemperature = restoreArray("matchedRecordedData.txt", 0)
rLongMoment = restoreArray("matchedRecordedData.txt", 1)
bTemperature = restoreArray("matchedBlankData.txt", 0)
bLongMoment = restoreArray("matchedBlankData.txt", 1)
eTemperature = restoreArray("matchedEicoData.txt", 0)
eLongMoment = restoreArray("matchedEicoData.txt", 1)

#Correct data by subtracting blank data from recorded data
correctedLongMoment = []
chiData = []
chiTData = []
count = 0
for i in rLongMoment:
    correctedLongMoment.append(float(i) - (((compoundEico/testEico)*(float(bLongMoment[count])-float(eLongMoment[count])))-float(eLongMoment[count])))
    chiData.append((correctedLongMoment[count]*molecularWeight)/(1000*compoundWeight))
    chiTData.append(float(chiData[count]) * float(rTemperature[count]))
    count = count + 1


#Write corrected data to file
outputFile = rFilePath + "_Corrected.txt"
dataWrite = open(outputFile, "w")
count = 0
dataWrite.write("Temperature (K),Uncorrected Long Moment (emu),Corrected Long Moment (emu),Chi,ChiT" + "\n")
for i in correctedLongMoment:
    dataWrite.write(rTemperature[count] + "," + repr(float(rLongMoment[count])) + "," + repr(i) + "," + repr(chiData[count]) + "," + repr(chiTData[count]) + "\n")
    count = count + 1 
dataWrite.close()

deleteFiles()
