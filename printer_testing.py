from win32print import *
import win32print


for c in win32print.__dict__:
    if c.startswith("PRINTER_STATUS"):
        print(c, win32print.__dict__[c])