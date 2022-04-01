from PIL import ImageGrab
from PIL import Image
import time
from pynput.keyboard import Key, Controller
keyboard = Controller()
from datetime import date

import numpy as np
import cv2
import re
import pytesseract
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

import DBinserter

from os import listdir
from os.path import isfile, join

def unsharp_mask(image, kernel_size=(5, 5), sigma=1.0, amount=1.0, threshold=0):
    # """Return a sharpened version of the image, using an unsharp mask."""
    blurred = cv2.GaussianBlur(image, kernel_size, sigma)
    sharpened = float(amount + 1) * image - float(amount) * blurred
    sharpened = np.maximum(sharpened, np.zeros(sharpened.shape))
    sharpened = np.minimum(sharpened, 255 * np.ones(sharpened.shape))
    sharpened = sharpened.round().astype(np.uint8)
    if threshold > 0:
        low_contrast_mask = np.absolute(image - blurred) < threshold
        np.copyto(sharpened, image, where=low_contrast_mask)
    return sharpened

# image stacker not mine
def stackImages(scale,imgArray):
    rows = len(imgArray)
    cols = len(imgArray[0])
    rowsAvailable = isinstance(imgArray[0], list)
    width = imgArray[0][0].shape[1]
    height = imgArray[0][0].shape[0]
    if rowsAvailable:
        for x in range ( 0, rows):
            for y in range(0, cols):
                if imgArray[x][y].shape[:2] == imgArray[0][0].shape [:2]:
                    imgArray[x][y] = cv2.resize(imgArray[x][y], (0, 0), None, scale, scale)
                else:
                    imgArray[x][y] = cv2.resize(imgArray[x][y], (imgArray[0][0].shape[1], imgArray[0][0].shape[0]), None, scale, scale)
                if len(imgArray[x][y].shape) == 2: imgArray[x][y]= cv2.cvtColor( imgArray[x][y], cv2.COLOR_GRAY2BGR)
        imageBlank = np.zeros((height, width, 3), np.uint8)
        hor = [imageBlank]*rows
        hor_con = [imageBlank]*rows
        for x in range(0, rows):
            hor[x] = np.hstack(imgArray[x])
        ver = np.vstack(hor)
    else:
        for x in range(0, rows):
            if imgArray[x].shape[:2] == imgArray[0].shape[:2]:
                imgArray[x] = cv2.resize(imgArray[x], (0, 0), None, scale, scale)
            else:
                imgArray[x] = cv2.resize(imgArray[x], (imgArray[0].shape[1], imgArray[0].shape[0]), None,scale, scale)
            if len(imgArray[x].shape) == 2: imgArray[x] = cv2.cvtColor(imgArray[x], cv2.COLOR_GRAY2BGR)
        hor= np.hstack(imgArray)
        ver = hor
    return ver

# decides where it is
def whereAmI(img):
    img2 = np.array(img)
    px = img2[620,2190] # 4K
    # px = img2[310,1095] # 720p
    std = np.full_like(px, 255)
    if px[0] == std[0] and px[1] == std[1] and px[2] == std[2]:
        imgType = 'choosingCar'
        # print('im choosing a car')
    else:
        imgType = 'prices'
        print('im in a car')
    return imgType

# image cutter
def imageCutter(img, imgType):
    # crops image
    if imgType == 'prices':
        img2 = np.array(img)
        price1 = img2[769:847, 1162:1888] # 4K
        price2 = img2[1054:1131, 1138:1864] # 4K
        price3 = img2[1340:1417, 1138:1864] # 4K
        price4 = img2[1626:1703, 1138:1864] # 4K
        # price1 = img2[384:423, 581:944] # 720p
        # price2 = img2[527:565, 569:932] # 720p
        # price3 = img2[670:708, 569:932] # 720p
        # price4 = img2[812:854, 569:932] # 720p
        cutImg = np.concatenate((price1,price2,price3,price4))
        return cutImg
    elif imgType == 'choosingCar':
        img2 = np.array(img)
        cutImg = img2[823:1004, 1890:2500] # 4K
        # cutImg = img2[411:502, 945:1250] # 720p
        return cutImg

# prices processer
def pricesProcessor(cutImg, imgType):
    if imgType == 'prices':
        # image processing
        imgGray = cv2.cvtColor(cutImg, cv2.COLOR_BGR2GRAY)
        imgGray = cv2.convertScaleAbs(imgGray, alpha=1.3, beta=0)
        # imgCanny = cv2.Canny(imgGray, 50, 50)
        # pricesText = pytesseract.image_to_string(imgGray, config='--oem 3 -c tessedit_char_whitelist=0123456789,@)\n\s ')
        pricesText = pytesseract.image_to_string(imgGray)
        # cv2.imshow('img', stackImages(.5,[[cutImg, imgGray, imgCanny],[img, img, img]]))
        # cv2.imshow('img', imgGray)
        # cv2.waitKey(0)
        return pricesText
    elif imgType == 'choosingCar':
        # image processing
        imgGray = cv2.cvtColor(cutImg, cv2.COLOR_BGR2GRAY)

        # a = 5.9     # primeiro (e único) que funfou
        # b = -1020

        # ++++++++++++++++++++++++++++++++++++++++++++++++
        # ADICIONAR ISSO AO CODIGO
        # ++++++++++++++++++++++++++++++++++++++++++++++++
        # a = 5.9     # nailed down
        # b = -1026
        # sharpened = cv2.convertScaleAbs(imgGray, alpha=a, beta=b)
        # pricesText = pytesseract.image_to_string(sharpened, config="-c preserve_interword_spaces=1 -c tessedit_char_whitelist=ABCDEFGHIJKLMNOPQRSTUVWXYZ/0123456789-.#\\' ")
        pricesText = pytesseract.image_to_string(imgGray, config="-c preserve_interword_spaces=1 -c tessedit_char_blacklist=$§][|")
        # ++++++++++++++++++++++++++++++++++++++++++++++++

        # cv2.imwrite(r'C:\Users\ASUS\Documents\Forza Prices Getter\imgsTest\cars\\'+str(file)+str(a)+str(b)+'.png', sharpened)
        # pricesText = pytesseract.image_to_string(imgGray) # was using config='--psm 11'
        # pricesText = pytesseract.image_to_string(imgGray, config="-c tessedit_char_blacklist=\\'\\‘]|") # \‘ not working
        # if '#98BMW325I' in pricesText:
        #     print('alpha = '+str(a),'beta = '+str(b))
        print(pricesText)
        return pricesText

# transforms text into average prices
def averager(text):
    # text clean up
    newText = ''
    for char in text:
        if char in ('0','1','2','3','4','5','6','7','8','9',' ','\n'):
            newText += char
    prices = re.findall('[0-9]*', newText)
    cutPrices = []
    for el in prices:
        if el != '':
            cutPrices.append(int(el))    
    print(cutPrices)

    # separation
    stPrices = []
    boPrices = []
    for price in cutPrices: # separates starting and buyout prices
        if cutPrices.index(price)%2 == 0:
            stPrices.append(price)
        else: 
            boPrices.append(price)
    sumStart = 0
    stCounter = 0
    for price in stPrices: # calculates average starting prices
        sumStart += price
        stCounter += 1
    if stCounter != 0:
        avgStart = int(sumStart/stCounter)
    else:
        avgStart = 'No listing found'
    sumBuyout = 0
    boCounter = 0
    for price in boPrices: # calculates average buyout prices
        sumBuyout += price
        boCounter += 1
    if boCounter != 0:
        avgBuyout = int(sumBuyout/boCounter)
    else:
        avgBuyout = 'No listing found'
    # printing result
    print('Average Starting Price: ', avgStart, '\nAverage Buyout Price: ', avgBuyout)
    return avgStart, avgBuyout

# cleans up make and model text
def modelIdentifyer(text):
    # cleanText = ''
    # for char in text:
    #     if char not in ('\n'):
    #         cleanText += char
    # # print(cleanText)
    # makePos = cleanText.find('MAKE') + 4
    # modelPos = cleanText.find('MODEL') + 5
    # make = cleanText[makePos:modelPos-5]
    # print(make)
    # model = cleanText[modelPos:]
    # print(model)
    makeNmodel = text.split('\n')
    make = makeNmodel[0]
    model = makeNmodel[2]
    return make, model

# ----- mobility functions -----
def checkUntilPixel(coord, rgb):
    x = coord[0]
    y = coord[1]
    r = rgb[0]
    g = rgb[1]
    b = rgb[2]
    img = ImageGrab.grab().load()
    px = img[x,y]
    std = np.array(rgb)
    while not (px[0] == std[0] and px[1] == std[1] and px[2] == std[2]):
        time.sleep(0.1)
        img = ImageGrab.grab().load()
        px = img[x,y]

def checkIfPixel(coord, rgb):
    x = coord[0]
    y = coord[1]
    r = rgb[0]
    g = rgb[1]
    b = rgb[2]
    img = ImageGrab.grab().load()
    px = img[x,y]
    std = np.array(rgb)
    if px[0] == std[0] and px[1] == std[1] and px[2] == std[2]:
        return True
    else:
        return False

def keytap(keyname, long = False):
    delayBefore = 0.05 # min acceptable without errors: 0.04 #4K
    # delayBefore = 0.1 # 720p
    delayBetween = 0.0 # 4K
    # delayBetween = 0.1 # 900p

    if long:
        delayBefore = 0.3 #4K
        # delayBefore = 0.6 #720p

    time.sleep(delayBefore)

    keyboard.press(Key[keyname])
    time.sleep(delayBetween)
    keyboard.release(Key[keyname])

# code routine for it to enter a car listing from the auction menu hovering
def getAllinfo():
    # IN AUCTION HOUSE TAB
    # (check if in auciton tab)
    checkUntilPixel((599, 382), (255, 255, 255)) # 4K
    # checkUntilPixel((289, 587), (255, 255, 255)) # 720p
    # checkUntilPixel((597, 508), (255, 255, 255)) # 900p
    print('im in acution menu')
    # ENTERS SEARCH
    # presses enter
    keytap('enter', long=False) # 4K
    # keytap('enter', long=True) # 900p
    print('i pressed enter')
    # IN SEARCH
    # checks if it is in search menu
    checkUntilPixel((2190,620),(255,255,255)) # 4K
    # checkUntilPixel((1095,310),(255,255,255)) # 720p
    print('checked until search menu')
    # HOVERS MAKE LINE
    # (in search menu) presses up arrow x6
    for i in range(6): keytap('up', long=False) # 4K
    # for i in range(6): keytap('up', long=True) # 900p
    print('pressed up 6 fold')
    # ENTERS 2D MAKES MENU
    # presses enter
    keytap('enter', long=False) # 4K
    # keytap('enter', long=True) # 900p
    print('pressed enter again')

    # ----- ALL CARS LOOPER ------
    # IN 2D MAKES MENU
    # checks if it is in choose manufacturer 2D menu
    checkUntilPixel((3258,312),(255,255,255)) # 4K
    # checkUntilPixel((1629,156),(255,255,255)) # 720p
    length = 6
    allinfo = []
    for row in range(1,26,1):
        if row == 25:
            length = 2
        for col in range(1,length,1):
            print(row, col)
            # HOVERING CAR MAKE IN 2D MENU (checks if it is really there)
            checkUntilPixel((1629,156),(255,255,255)) # 720p
            # presses right
            keytap('right', long=True)
            if col == 5:
                # IN FIRST COLUMN
                # presses down
                keytap('down', long=True)
            # SELECTS CAR MAKE IN 2D MENU
            # presses enter
            keytap('enter', long=True)
            # IN SEARCH
            checkUntilPixel((2190,620),(255,255,255)) # 4K
            # checkUntilPixel((1095,310),(255,255,255)) # 720p
            # goes to confirm
            for i in range(6):
                # keytap('down', long=False) #4K
                keytap('down', long=True) # 900p
            # IN SEARCH
            # selects model
            counter = 0
            while True:
                counter += 1
                print('while true round: '+str(counter))
                # IN SEARCH
                isAny, make, model = modelSelector()
                # HOVERING CONFIRM IN SEARCH
                if isAny:
                    # HOVERS MAKE LINE
                    # press up x6
                    # for i in range(6): keytap('up', long=False) #4K
                    for i in range(6): keytap('up', long=True) #900p
                    # breaks the while true
                    print('i will break now')
                    break
                print('if i should have broke, i did not')
                # ENTERS LISTINGS
                avgStart, avgBuyout = grabPrices()
                # REENTERING SEARCH
                today = str(date.today())
                # info flow (allinfo is [[make, model, avgStart, avgBuyout, date],...])
                infoList = [make, model, avgStart, avgBuyout, today]
                # writes it in DB
                DBinserter.insert(infoList)
                # writes it in the file
                with open('prices.txt', 'a') as f:
                    for item in infoList:
                        f.write("%s\n" % item)
                        # f.write("%s," % item) # uncomment for final use
                    f.write("\n")
                    # f.write(";\n") # uncomment and remove \n for final use
                    f.close()
                allinfo.append(infoList)
                print(allinfo)
            # HOVERING MAKE LINE IN SEARCH
            keytap('enter', long=True)
    return allinfo

def readMakeNmodel():
    time.sleep(0.1) # 0.08 min for no errors #4K

    # following code block for # 900p
    time.sleep(0.1)
    modelIsReadable = checkIfPixel((864,488),(255,255,255))
    counter = 0
    while modelIsReadable == False:
        # see if it's lag (by checking some times if it will become white)
        time.sleep(0.1)
        modelIsReadable = checkIfPixel((864,488),(255,255,255))
        counter += 1
        if counter > 10:
            keytap('down', long=False)
            time.sleep(0.1)
            break

    #checks until model text has white background
    checkUntilPixel((864,488),(255,255,255)) #720p
    
    # looks at screen
    img = ImageGrab.grab()

    # decides where it is
    imgType = whereAmI(img)

    # crops img
    cutImg = imageCutter(img, imgType)
    print('image is cut!')
    # cv2.imshow('img', cutImg)
    # cv2.waitKey(0)

    # image processing
    pricesText = pricesProcessor(cutImg, imgType)
    print(pricesText)

    # text clean up
    if imgType == 'prices':
        avgStart, avgBuyout = averager(pricesText)
    elif imgType == 'choosingCar':
        time.sleep(0.1) # 720p
        make, model = modelIdentifyer(pricesText)

    return make, model

def modelSelector():
    isAny = False
    # IN SEARCH
    # checks if it is in search menu
    checkUntilPixel((2190,620),(255,255,255)) # 4K
    # checkUntilPixel((1095,310),(255,255,255)) # 720p
    # IN SEARCH
    # up x5, right, down
    for i in range(5): keytap('up', long=False) # 4K vvv
    keytap('right', long=False)
    keytap('down', long=False)
    # for i in range(5): keytap('up', long=True) # 900p vvv
    # keytap('right', long=True)
    # keytap('down', long=True)
    # IN SEARCH
    # read make and model
    make, model = readMakeNmodel()
    if model == 'ANY':
        isAny = True
    # IN SEARCH HOVERS CONFIRM
    # down x4
    for i in range(4): keytap('down', long=False) # 4K
    # for i in range(4): keytap('down', long=True) # 900p
    return isAny, make, model

def readPrices():
    # IN LISTINGS
    # checks until in listings (auction house label)
    checkUntilPixel((1015,342),(255,255,255)) # 4K
    # checkUntilPixel((507,171),(255,255,255)) # 720p
    noCars = False
    hasCars = False
    # LISTINGS LOADING
    while True:
        # looks at tip of the Y in "no auctions to display"
        noCars = checkIfPixel((3114,1092), (255,255,255)) # 4K
        # noCars = checkIfPixel((1557,546), (255,255,255)) # 720p
        # noCars = checkIfPixel((1550,563), (255,255,255)) # 900p
        if noCars:
            # NO AUCTIONS TO DISPLAY appeared
            break
        # looks at green tile "auction details"
        hasCars = checkIfPixel((3590,520), (0,181,146)) # 4K
        # hasCars = checkIfPixel((1795,260), (0,181,146)) # 720p
        if hasCars:
            # AUCTION DETAILS GREEN appeared
            break
        time.sleep(0.1)
    # LOADING CARS IN LISTINGS
    # checks if car class obj appeared
    white = True
    white = checkIfPixel((1874,607),(255,255,255)) # 4K
    # white = checkIfPixel((937,303),(255,255,255)) # 720p
    while white:
        time.sleep(0.1)
        white = checkIfPixel((1874,607),(255,255,255)) # 4K
        # white = checkIfPixel((937,303),(255,255,255)) # 720p

    time.sleep(0.3) # 0.3 according to the recording
    # ALL APPEARED IN LISTINGS
    # looks at screen
    img = ImageGrab.grab()

    # decides where it is
    imgType = whereAmI(img)

    # crops img
    cutImg = imageCutter(img, imgType)
    print('image is cut!')
    # cv2.imshow('img', cutImg)
    # cv2.waitKey(0)

    # image processing
    pricesText = pricesProcessor(cutImg, imgType)
    print(pricesText)

    # text clean up
    if imgType == 'prices':
        avgStart, avgBuyout = averager(pricesText)
    elif imgType == 'choosingCar':
        make, model = modelIdentifyer(pricesText)

    return avgStart, avgBuyout

def grabPrices():
    # HOVERING CONFIRM IN SEARCH
    # checks if it is in search menu
    checkUntilPixel((2190,620),(255,255,255)) # 4K
    # checkUntilPixel((1095,310),(255,255,255)) # 720p
    # ENTERS LISTINGS
    # go to listing (press enter)
    keytap('enter', long=False)
    # IN LISTINGS
    # read price
    avgStart, avgBuyout = readPrices()
    # RETURNS FROM LISTINGS TO AUCTION TAB
    # exit
    keytap('esc', long=False)

    time.sleep(0.9) # 0.8 min to work, 4K
    # time.sleep(1) # 720p
    # (check if in auciton tab)
    checkUntilPixel((599, 382), (255, 255, 255)) # 4K
    # checkUntilPixel((289, 587), (255, 255, 255)) # 720p
    # checkUntilPixel((597, 508), (255, 255, 255)) # 900p
    # checkUntilPixel((565, 580), (255, 255, 255)) # 1080p
    
    # IN AUCTION TAB
    # time.sleep(0.5) # 720p
    # enter
    keytap('enter', long=False)
    # ENTERING SEARCH
    return avgStart, avgBuyout


mypath = r'C:\Users\ASUS\Documents\Forza Prices Getter\nailing'
onlyfiles = [f for f in listdir(mypath) if isfile(join(mypath, f))]

for file in onlyfiles:

    # print(file)
    img = cv2.imread(r'C:\Users\ASUS\Documents\Forza Prices Getter\nailing\\'+file)
    img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    im_pil = Image.fromarray(img)
    # # For reversing the operation:
    # im_np = np.asarray(im_pil)  

    # decides where it is
    imgType = whereAmI(img)

    # crops img
    cutImg = imageCutter(img, imgType)
    # cv2.imshow('img', cutImg)
    # cv2.waitKey(0)

    # image processing
    pricesText = pricesProcessor(cutImg, imgType)
    # print(pricesText)

    # text clean up
    if imgType == 'prices':
        avgStart, avgBuyout = averager(pricesText)
    elif imgType == 'choosingCar':
        make, model = modelIdentifyer(pricesText)

    # print(make, model)