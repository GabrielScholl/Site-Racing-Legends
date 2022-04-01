# coding=Windows_1252

import difflib

def match(make, model):
    officialMakes = []
    officialModels = []
    makesFile = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\makes.txt'
    modelsFile = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\models.txt'
    with open(makesFile, 'r') as m:
        for l in m:
            officialMakes.append(l[:-1])
    with open(modelsFile, 'r') as m:
        for l in m:
            officialModels.append(l[:-1])


    # print(make)
    # print(officialMakes)
    # print(model)
    # print(officialModels)
    makeMatches = difflib.get_close_matches(make, officialMakes, n=3, cutoff=0.6)
    make = makeMatches[0]
    modelMatches = difflib.get_close_matches(model, officialModels, n=3, cutoff=0.6)
    model = modelMatches[0]

    # print(make)
    # print(model)

    return make, model