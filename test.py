import sys

sampleMass = sys.argv[0]
fileWrite = open("upload/test.txt", "w")
fileWrite.write(sampleMass)
fileWrite.close()
