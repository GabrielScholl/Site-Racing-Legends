# coding=Windows_1252

import DBinserter
from os import listdir
from os.path import isfile, join
import time

def infoRetriever(file):
    infoList = []
    allValues = []
    c = 0
    with open(file) as f:
        for l in f:
            c += 1
            if l != '\n':
                l = l.replace('\n','')
                infoList.append(l)
            if c == 5:
                # DBinserter.insert(infoList)
                allValues.append(infoList)
                infoList = []
                c = -1
    DBinserter.insert(allValues, midCode=False)


mypath = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\prices'
# mypath = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\prices2'
onlyfiles = [f for f in listdir(mypath) if isfile(join(mypath, f))]

total_start = time.time()
for file in onlyfiles:
    file = mypath + '\\' + file
    print(file)
    start = time.time()
    print('Transferring file: '+file)
    infoRetriever(file)
    print('Done')
    end = time.time()
    print('This file took '+str(end-start)+' seconds')

total_end = time.time()
print('FINISHED')
print('Total took '+str((total_end-total_start)/60)+' minutes')