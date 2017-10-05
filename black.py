import win32print, requests, time

def get_printers():
    """ Return printer data. """
    return win32print.EnumPrinters(win32print.PRINTER_ENUM_LOCAL)

def get_printer_stats():
    data = get_printers()
    offline_data = []
    for tup in data:
        handle = win32print.OpenPrinter(tup[2], {"DesiredAccess": win32print.PRINTER_ALL_ACCESS})
        try:
            status = win32print.GetPrinter(handle)
            if status[18] >= 8192:
                offline_data.append(1)
            else:
                offline_data.append(0)
        except Exception as e:
            print(e)
    count_1 = offline_data.count(1)
    count_0 = offline_data.count(0)
    if count_1 > count_0:
        return 1
    return 0

def disable_printers():
    data = get_printers()
    for tup in data:
        handle = win32print.OpenPrinter(tup[2], {"DesiredAccess": win32print.PRINTER_ALL_ACCESS})
        try:
            win32print.SetPrinter(handle, 0, win32print.PRINTER_STATUS_OFFLINE,
                                        win32print.PRINTER_CONTROL_SET_STATUS)
        except Exception as e:
            print(e)

def enable_printers():
    data = get_printers()
    for tup in data:
        handle = win32print.OpenPrinter(tup[2], {"DesiredAccess": win32print.PRINTER_ALL_ACCESS})
        try:
            win32print.SetPrinter(handle, 0, win32print.PRINTER_STATUS_WAITING,
                                        win32print.PRINTER_CONTROL_SET_STATUS)
        except Exception as e:
            print(e)


def get_status(url):
    """ Get status from web API, return True if disabled, False if enabled. """
    req = requests.get(url)
    if req.text == "offline" or req.text == "disable":
        return True
    return False

if __name__ == "__main__":
    url = ""
    if get_printer_stats() == 1:
        already_disabled = False
    else:
        already_disabled = True
    i = 1
    while (True):
        try:
            disabled = get_status(url)
            if disabled and not already_disabled:
                disable_printers()
                already_disabled = True
            elif not disabled and already_disabled:
                enable_printers()
                already_disabled = False
            time.sleep(2)
            print("Iteration " + str(i) + " complete.")
            i += 1
        except Exception as e:
            print(e)
