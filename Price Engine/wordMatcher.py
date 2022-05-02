# coding=Windows_1252

import difflib

def match(make, model):
    officialMakes = []
    officialModels = []
    # makesFile = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\makes.txt'
    # modelsFile = r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\models.txt'
    makesFile = r'G:\Forza Prices Getter from ASUS and PC in 13-02-2021\makes.txt'
    modelsFile = r'G:\Forza Prices Getter from ASUS and PC in 13-02-2021\models.txt'
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
    makeMatches = difflib.get_close_matches(make, officialMakes, n=3, cutoff=0.7) # changed cutoff (+0.1) in 18/05/2021
    make = makeMatches[0]
    modelMatches = difflib.get_close_matches(model, officialModels, n=3, cutoff=0.7) # changed cutoff (+0.1) in 18/05/2021
    model = modelMatches[0]

    # print(make)
    # print(model)

    return make, model