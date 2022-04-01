from PIL import ImageGrab
import time
from pynput.keyboard import Key, Controller
keyboard = Controller()
from pynput.mouse import Button, Controller
mouse = Controller()
from datetime import date

import numpy as np
import cv2
import re
import pytesseract

screenResolution = "1080p"
if screenResolution == "1080p":
    pytesseract.pytesseract.tesseract_cmd = r'D:\Program Files\Tesseract-OCR\tesseract.exe'
else: # 4K
    pytesseract.pytesseract.tesseract_cmd = r'G:\Program Files\Tesseract-OCR\tesseract.exe'

import random as rnd

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
    if screenResolution == "4K":
        px = img2[620,2190] # 4K
    elif screenResolution == "1080p":
        px = img2[310,1095] # 1080p
    std = np.full_like(px, 255)
    if px[0] == std[0] and px[1] == std[1] and px[2] == std[2]:
        imgType = 'choosingCar'
        print('im choosing a car')
    else:
        imgType = 'prices'
        print('im in a car')
    return imgType

# image cutter
def imageCutter(img, imgType):
    # crops image
    if imgType == 'prices':
        img2 = np.array(img)
        if screenResolution == "4K":
            price1 = img2[769:847, 1162:1888] # 4K
            price2 = img2[1054:1131, 1138:1864] # 4K
            price3 = img2[1340:1417, 1138:1864] # 4K
            price4 = img2[1626:1703, 1138:1864] # 4K
        elif screenResolution == "1080p":
            price1 = img2[384:423, 581:944] # 1080p
            price2 = img2[527:565, 569:932] # 1080p
            price3 = img2[670:708, 569:932] # 1080p
            price4 = img2[812:854, 569:932] # 1080p
        cutImg = np.concatenate((price1,price2,price3,price4))
        return cutImg
    elif imgType == 'choosingCar':
        img2 = np.array(img)
        if screenResolution == "4K":
            cutImg = img2[823:1004, 1890:2500] # 4K
        elif screenResolution == "1080p":
            cutImg = img2[411:502, 945:1250] # 1080p
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
        # imgGray = cv2.convertScaleAbs(imgGray, alpha=1.3, beta=0)
        # cv2.imshow('img', stackImages(.5,[[cutImg, imgGray, img],[img, img, img]]))
        # cv2.waitKey(0)
        pricesText = pytesseract.image_to_string(imgGray, config='-c tessedit_char_blacklist=$§][|') # was using config='--psm 11'
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
    print(makeNmodel)
    make = makeNmodel[0]
    model = makeNmodel[2]
    print(make)
    print(model)
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
        time.sleep(0.1 + rnd.random()/50) # random
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
    delayBefore = 0.05 # min acceptable without errors: 0.04
    delayBetween = 0.0
    if screenResolution == "1080p":
        delayBetween = 0.01

    if long:
        delayBefore = 0.3

    time.sleep(delayBefore + rnd.random()/100) # random

    keyboard.press(Key[keyname])
    time.sleep(delayBetween)
    keyboard.release(Key[keyname])

# code routine for it to enter a car listing from the auction menu hovering
def getAllinfo():
    # IN AUCTION HOUSE TAB
    # (check if in auciton tab)
    if screenResolution == "4K":
        checkUntilPixel((599, 382), (255, 255, 255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((300, 565), (255, 255, 255)) # 1080p
    print('im in acution menu')
    # ENTERS SEARCH
    # presses enter
    keytap('enter', long=False)
    print('i pressed enter')
    # IN SEARCH
    # checks if it is in search menu
    if screenResolution == "4K":
        checkUntilPixel((2190,620),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((1095,310),(255,255,255)) # 1080p
    print('checked until search menu')
    # HOVERS MAKE LINE
    # (in search menu) presses up arrow x6
    for i in range(6): keytap('up', long=False)
    print('pressed up 6 fold')
    # ENTERS 2D MAKES MENU
    # presses enter
    keytap('enter', long=False)
    print('pressed enter again')

    # ----- ALL CARS LOOPER ------
    # IN 2D MAKES MENU
    # checks if it is in choose manufacturer 2D menu
    if screenResolution == "4K":
        checkUntilPixel((3258,312),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((1629,156),(255,255,255)) # 1080p
    length = 6
    allinfo = []
    for row in range(1,26,1):
        if row == 25:
            length = 2
        for col in range(1,length,1):
            print(row, col)
            # HOVERING CAR MAKE IN 2D MENU
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
            if screenResolution == "4K":
                checkUntilPixel((2190,620),(255,255,255)) # 4K
            elif screenResolution == "1080p":
                checkUntilPixel((1095,310),(255,255,255)) # 1080p
            # goes to confirm
            for i in range(6):
                keytap('down', long=False)
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
                    for i in range(6): keytap('up', long=False)
                    # breaks the while true
                    print('i will break now')
                    break
                print('if i should have broke, i did not')
                # ENTERS LISTINGS
                avgStart, avgBuyout = grabPrices()
                # REENTERING SEARCH
                today = date.today()
                # info flow (allinfo is [[make, model, avgStart, avgBuyout, date],...])
                infoList = [make, model, avgStart, avgBuyout, today]
                # writes it in the file
                if screenResolution == "1080p":
                    with open(r'C:\Users\Nome\Documents\Forza Prices Getter from ASUS and PC\\valores-'+str(today)+'.txt', 'a') as f:
                        for item in infoList:
                            f.write("%s\n" % item)
                        f.write("\n")
                        f.close()
                else: # 4K
                    with open('G:\Forza Prices Getter\\valores-'+str(today)+'.txt', 'a') as f:
                        for item in infoList:
                            f.write("%s\n" % item)
                        f.write("\n")
                        f.close()
                allinfo.append(infoList)
                print(allinfo)
                
            # HOVERING MAKE LINE IN SEARCH
            keytap('enter', long=True)
    # #remove last Zenvo repeated readings(pending, make this)
    # fd=open('G:\Forza Prices Getter\\valores-'+str(today)+'.txt',"r+")
    # d=fd.read()
    # fd.truncate(0)
    # fd.close()
    # m=d.split("\n")
    # s="\n".join(m[:-13])
    # fd=open('G:\Forza Prices Getter\\valores-'+str(today)+'.txt',"w+")
    # for i in range(len(s)):
    #     fd.write(s[i])
    # fd.close()
    return allinfo

def readMakeNmodel():
    time.sleep(0.1) # 0.08 min for no errors
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
        return avgStart, avgBuyout
    elif imgType == 'choosingCar':
        make, model = modelIdentifyer(pricesText)
        return make, model

def modelSelector():
    isAny = False
    # IN SEARCH
    # checks if it is in search menu
    if screenResolution == "4K":
        checkUntilPixel((2190,620),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((838,328),(255,255,255)) # 1080p
    # IN SEARCH
    # up x5, right, down
    for i in range(5): keytap('up', long=False)
    keytap('right', long=False)
    keytap('down', long=False)
    # IN SEARCH
    # read make and model
    make, model = readMakeNmodel()
    if model == 'ANY' or model == 'ANN':
        isAny = True
    # IN SEARCH HOVERS CONFIRM
    # down x4
    for i in range(4): keytap('down', long=False)
    return isAny, make, model

def readPrices():
    # IN LISTINGS
    # checks until in listings (auction house label)
    if screenResolution == "4K":
        checkUntilPixel((1015,342),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((507,171),(255,255,255)) # 1080p
    noCars = False
    hasCars = False
    # LISTINGS LOADING
    while True:
        # looks at tip of the Y in "no auctions to display"
        if screenResolution == "4K":
            noCars = checkIfPixel((3114,1092), (255,255,255)) # 4K
        elif screenResolution == "1080p":
            noCars = checkIfPixel((1557,546), (255,255,255)) # 1080p
        if noCars:
            # NO AUCTIONS TO DISPLAY appeared
            break
        # looks at green tile "auction details"
        if screenResolution == "4K":
            hasCars = checkIfPixel((3590,520), (0,181,146)) # 4K
        elif screenResolution == "1080p":
            hasCars = checkIfPixel((1795,260), (0,181,146)) # 1080p
        if hasCars:
            # AUCTION DETAILS GREEN appeared
            break
        time.sleep(0.1)
    # LOADING CARS IN LISTINGS
    # checks if car class obj appeared
    white = True
    if screenResolution == "4K":
        white = checkIfPixel((1874,607),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        white = checkIfPixel((937,303),(255,255,255)) # 1080p
    while white:
        time.sleep(0.1)
        if screenResolution == "4K":
            white = checkIfPixel((1874,607),(255,255,255)) # 4K
        elif screenResolution == "1080p":
            white = checkIfPixel((937,303),(255,255,255)) # 1080p

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
    if screenResolution == "4K":
        checkUntilPixel((2190,620),(255,255,255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((1095,310),(255,255,255)) # 1080p
    # ENTERS LISTINGS
    # go to listing (press enter)
    keytap('enter', long=False)
    # IN LISTINGS
    # read price
    avgStart, avgBuyout = readPrices()
    # RETURNS FROM LISTINGS TO AUCTION TAB
    # exit
    keytap('esc', long=False)
    time.sleep(0.9) # 0.8 min to work, 0.4 from recording... fuck this, checkUntil...
    if screenResolution == "4K":
        checkUntilPixel((599, 382), (255, 255, 255)) # 4K
    elif screenResolution == "1080p":
        checkUntilPixel((300, 565), (255, 255, 255)) # 1080p
    # IN AUCTION TAB
    # enter
    keytap('enter', long=False)
    # ENTERING SEARCH
    return avgStart, avgBuyout

def gameReopener(starting=False):
    # check if windows button can be seen
    if screenResolution == "4K":
        windows = checkIfPixel((34,2130), (255,255,255)) # 4K
    elif screenResolution == "1080p":
        windows = checkIfPixel((34,1050), (255,255,255)) # 1080p

    if windows == True:
        if screenResolution == "1080p":
            # IN DESKTOP
            # click game
            # mouse.position = (190,2134) # 4K
            mouse.position = (190,1055) # 1080p
            mouse.click(Button.left, 1)
            # mouse.position = (3646,954) # 4K
            mouse.position = (1889,527) # 1080p
            # GAME OPENING
            # wait to press enter
            # checkUntilPixel((3507,1987),(255,255,255)) # 4K
            checkUntilPixel((1701,714),(255,255,255)) # 1080p
            time.sleep(0.1 + rnd.random()/10)
            keytap('enter', long=True)
            while checkIfPixel((1790,872),(255,255,255)) == False:
                time.sleep(0.1 + rnd.random()/10)
                keytap('enter', long=True)
            # waits to press enter again
            # checkUntilPixel((2952,1842),(255,255,255)) # 4K
            checkUntilPixel((1790,872),(255,255,255)) # 1080p
            keytap('enter', long=True)
            while checkIfPixel((1790,872),(255,255,255)) == True:
                time.sleep(0.1 + rnd.random()/10)
                keytap('enter', long=True)
            # esc x2
            # checkUntilPixel((3700,1140),(255,255,255)) # 4K
            checkUntilPixel((1848,572),(255,255,255)) # 1080p
            keytap('esc', long=True)
            # checkUntilPixel((1504,256),(255,255,255)) # 4K
            checkUntilPixel((741,135),(255,255,255)) # 1080p
            keytap('esc', long=True)
            # pg down x2
            # checkUntilPixel((2326,288),(255,255,255)) # 4K
            checkUntilPixel((1010,150),(255,255,255)) # 1080p
            # for i in range(2): keytap('page_down', long=False) # 4K
            for i in range(2): keytap('page_down', long=True) # 1080p
            while checkIfPixel((800,560),(255,255,255)) == False:
                time.sleep(2 + rnd.random())
                keytap('page_down', long=True)
            # checkUntilPixel((1240,1048),(255,255,255)) # 4K
            checkUntilPixel((800,560),(255,255,255)) # 1080p
            keytap('left', long=True)
            # open search, up x6, enter, press down row times and right col times
        elif screenResolution == "4K":
            # IN DESKTOP
            # click game
            mouse.position = (190,2134) # 4K
            # mouse.position = (219,1055) # 1080p
            mouse.click(Button.left, 1)
            mouse.position = (3646,954) # 4K
            # mouse.position = (1889,527) # 1080p
            # GAME OPENING
            # wait for press enter
            checkUntilPixel((3507,1987),(255,255,255)) # 4K
            # checkUntilPixel((1701,714),(255,255,255)) # 1080p
            keytap('enter', long=True)
            # waits to press enter again
            checkUntilPixel((2952,1842),(255,255,255)) # 4K
            # checkUntilPixel((1790,872),(255,255,255)) # 1080p
            keytap('enter', long=True)
            # esc x2
            checkUntilPixel((3700,1140),(255,255,255)) # 4K
            # checkUntilPixel((1848,572),(255,255,255)) # 1080p
            keytap('esc', long=True)
            checkUntilPixel((1504,256),(255,255,255)) # 4K
            # checkUntilPixel((741,135),(255,255,255)) # 1080p
            keytap('esc', long=True)
            # pg down x2
            checkUntilPixel((2326,288),(255,255,255)) # 4K
            # checkUntilPixel((1160,150),(255,255,255)) # 1080p
            for i in range(2): keytap('page_down', long=False) # 4K
            # for i in range(2): keytap('page_down', long=True) # 1080p
            checkUntilPixel((1240,1048),(255,255,255)) # 4K
            # checkUntilPixel((800,560),(255,255,255)) # 1080p
            keytap('left', long=True)
            # open search, up x6, enter, press down row times and right col times
        if not starting:
            if screenResolution == "4K":
                keytap('enter', long=True)
                for i in range(6): keytap('up', long=False)
                keytap('enter', long=False)
                for i in range(row): keytap('down', long=False)
                for i in range(col): keytap('right', long=False)
                keytap('enter', long=False)
                keytap('down', long=False)
                keytap('right', long=False)
                keytap('down', long=False)
            elif screenResolution == "1080p":
                keytap('enter', long=True)
                for i in range(6): keytap('up', long=True)
                keytap('enter', long=True)
                for i in range(row): keytap('down', long=True)
                for i in range(col): keytap('right', long=True)
                keytap('enter', long=True)
                keytap('down', long=True)
                keytap('right', long=True)
                keytap('down', long=True)
            # IS NOW IN SEARCH WAITING TO READ model
            # see if at any given time it can return to search
            # or go to where it was based on which function call was it

start = time.time()

gameReopener(starting=True)
allinfo = getAllinfo()
print(allinfo)

end = time.time()
print('Time taken to take prices pic: '+str((end - start)/3600))