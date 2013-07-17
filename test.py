import sys

sampleMass = sys.argv[1]
fileWrite = open("upload/test.txt", "w")
fileWrite.write(sampleMass)
fileWrite.close()
