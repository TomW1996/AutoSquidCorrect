def matchDataPoints(tempA, lmA, tempB, lmB, filePathA, filePathB, iteration):
    matchedLM = []
    deletions = 0
    startDelete = False
    count = 0
    startIndex = 0
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
                startIndex = startIndex + 1
        else:
            deletions = deletions + 1
        count = count + 1
        
    #Write data to file
    dataWrite = open(filePathA, "w")
    lmCount = 0
    for i in range(startIndex, len(tempA) - deletions):
        dataWrite.write(repr(float(tempA[i])) + "," + repr(matchedLM[lmCount]) + "\n")
        lmCount = lmCount + 1
    dataWrite.close()
    if iteration == 0:
        dataWrite = open(filePathB, "w")
        startIndex = 0
        if startDelete == True:
            startIndex = 1
        for i in range(startIndex, len(tempA) - deletions):
            dataWrite.write(repr(float(tempA[i])) + "," + (lmA[i]))
        dataWrite.close()
