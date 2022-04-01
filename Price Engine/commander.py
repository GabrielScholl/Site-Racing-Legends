
# grabs img 
# decides where it is (choosing car OR car prices) (V)
# chooses processing mode based on where it is (processing 1 OR 2) (V)
# returns appropriate result (car name OR price) (V)
# goes into car prices OR goes back to choosing car 
# 
# add menu

from PIL import ImageGrab
import time
from pynput.keyboard import Key, Controller
keyboard = Controller()

import numpy as np
import cv2
import re
import pytesseract  
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

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
    px = img[620][2190]
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
        price1 = img[769:847, 1162:1888]
        price2 = img[1054:1131, 1138:1864]
        price3 = img[1340:1417, 1138:1864]
        price4 = img[1626:1703, 1138:1864]
        cutImg = np.concatenate((price1,price2,price3,price4))
        return cutImg
    elif imgType == 'choosingCar':
        cutImg = img[823:1004, 1890:2500]
        return cutImg

# prices processer
def pricesProcessor(cutImg, imgType):
    if imgType == 'prices':
        # image processing
        imgGray = cv2.cvtColor(cutImg, cv2.COLOR_BGR2GRAY)
        imgGray = cv2.convertScaleAbs(imgGray, alpha=1.3, beta=0)
        imgCanny = cv2.Canny(imgGray, 50, 50)
        pricesText = pytesseract.image_to_string(imgCanny, config='--psm 11')
        cv2.imshow('img', stackImages(.5,[[cutImg, imgGray, imgCanny],[img, img, img]]))
        cv2.waitKey(0)
        return pricesText
    elif imgType == 'choosingCar':
        # image processing
        imgGray = cv2.cvtColor(cutImg, cv2.COLOR_BGR2GRAY)
        # imgGray = cv2.convertScaleAbs(imgGray, alpha=1.3, beta=0)
        # cv2.imshow('img', stackImages(.5,[[cutImg, imgGray, img],[img, img, img]]))
        # cv2.waitKey(0)
        pricesText = pytesseract.image_to_string(imgGray, config='--psm 11')
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
        time.sleep(.3)
        img = ImageGrab.grab().load()
        px = img[x,y]
    time.sleep(.5)

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
# code routine for it to enter a car listing from the auction menu hovering
def getInCar():
# (in auciton menu)
    checkUntilPixel((599, 382), (255, 255, 255))
# presses enter
    keyboard.tap(Key.enter)
# checks if it is in search menu
    checkUntilPixel((2190,620),(255,255,255))
# (in search menu) presses up arrow x6
    for i in range(6):
        keyboard.tap(Key.up)
# presses enter
    keyboard.tap(Key.enter)
# checks if it is in choose manufacturer 2D menu
    checkUntilPixel((3258,312),(255,255,255))
# if 'a bit right' = white: press right arrow; else: (it is right end or zenvo end) press right and down;
    if checkIfPixel((x, y), (r, g, b)) == True:
        keyboard.tap(Key.right)
    else:
        keyboard.tap(Key.right)
        keyboard.tap(Key.down)
# press enter
    keyboard.tap(Key.enter)
# (in search menu)
    checkUntilPixel((2190,620),(255,255,255))
# press down
    keyboard.tap(Key.down)
# press right
    keyboard.tap(Key.right)
# press down
    keyboard.tap(Key.down)
# if model = any: chose another make; else: (still another model to go) press enter
    
# (in car listings)
# grabs prices

# gets image
path = 'Captura de Tela (495).png'
path = 'Captura de Tela (498).png'
path = 'Captura de Tela (508).png'
path = 'Captura de Tela (507).png'
path = 'Captura de Tela (497).png'
path = 'Captura de Tela (496).png'
path = 'Captura de Tela (510).png'
for i in (525, 527, 528,530,531,532,533,534,535):
    path = 'Captura de Tela (' + str(i) + ').png'
    img = cv2.imread(path)

    # decides where it is
    imgType = whereAmI(img)

    # crops img
    cutImg = imageCutter(img, imgType)
    cv2.imshow('img', cutImg)
    cv2.waitKey(0)

    # image processing
    pricesText = pricesProcessor(cutImg, imgType)
    print(pricesText)

    # text clean up
    if imgType == 'prices':
        avgStart, avgBuyout = averager(pricesText)
    elif imgType == 'choosingCar':
        make, model = modelIdentifyer(pricesText)



# with ImageGrab.grab() as img:
#     px = im.load()

# im.show()