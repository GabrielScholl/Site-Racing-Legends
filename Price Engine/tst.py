from PIL import ImageGrab
import time
from pynput.keyboard import Key, Controller
keyboard = Controller()

import numpy as np
import cv2
import re
import pytesseract
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

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
    # time.sleep(.5)

t = 0.3
press = 0.0
length = 6
checkUntilPixel((3258,312),(255,255,255))
for row in range(1,26,1):
    if row == 25:
        length = 2
    for col in range(1,length,1):
        print(row, col)
        # presses right
        time.sleep(t)
        keyboard.press(Key.right)
        time.sleep(press)
        keyboard.release(Key.right)
        if col == 5:
            # presses down
            time.sleep(t)
            keyboard.press(Key.down)
            time.sleep(press)
            keyboard.release(Key.down)
        # presses enter
        time.sleep(t)
        keyboard.press(Key.enter)
        time.sleep(press)
        keyboard.release(Key.enter)
        # in search -> grab car name -> listing -> grab price -> exit -> enter -> in search ->
        # -> up x6
        # grabPrices()
        time.sleep(t)
        keyboard.press(Key.enter)
        time.sleep(press)
        keyboard.release(Key.enter)
